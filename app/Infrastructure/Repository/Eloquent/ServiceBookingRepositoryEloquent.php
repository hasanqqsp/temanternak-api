<?php

namespace App\Infrastructure\Repository\Eloquent;

use App\Commons\Exceptions\NotFoundException;
use App\Domain\ServiceBookings\Entities\NewBooking;
use App\Domain\ServiceBookings\Entities\ServiceBooking as EntitiesServiceBooking;
use App\Domain\ServiceBookings\ServiceBookingRepository;
use App\Domain\Transactions\Entities\Transaction;
use App\Domain\Users\Entities\ShortUser;
use App\Domain\Users\Entities\User;
use App\Domain\Veterinarians\Entities\VeterinarianShort;
use App\Domain\VeterinarianServices\Entities\VetService;
use App\Domain\VeterinarianServices\Entities\VetServiceOnly;
use App\Infrastructure\Repository\Models\Consultation;
use App\Infrastructure\Repository\Models\ServiceBooking;
use Carbon\Carbon;


class ServiceBookingRepositoryEloquent implements ServiceBookingRepository
{
    public function reschedule($bookingId, $newStartTime)
    {
        $booking = ServiceBooking::find($bookingId);
        $newStartTime = new Carbon($newStartTime);
        if ($booking) {
            $booking->rescheduled_from = $booking->start_time;
            $booking->start_time = $newStartTime->toDateTime();
            $booking->end_time = $newStartTime->addMinutes($booking->service->duration)->subSecond()->toDateTime();
            $booking->rescheduled_at = now();
            $booking->save();
        }
    }

    public function setRebookingId($bookingId, $rebookingId)
    {
        $booking = ServiceBooking::find($bookingId);
        if ($booking) {
            $booking->rebooking_id = $rebookingId;
            $booking->save();
        }
    }

    public function checkIsRefundable($bookingId)
    {
        $booking = ServiceBooking::find($bookingId);
        if ($booking && $booking->status === 'FAILED' && $booking->is_refundable) {
            return true;
        }
        throw new NotFoundException("Booking is not refundable");
    }

    public function checkIfExists($bookingId)
    {
        $booking = ServiceBooking::find($bookingId);
        if (!$booking) {
            throw new NotFoundException("Booking not found");
        }
        return true;
    }

    public function getAll($page)
    {
        // dd(ServiceBooking::with(["consultation", "transaction", "booker", "service"])->simplePaginate(10, ["*"], 'page', $page)->items());
        $results = ServiceBooking::with(["consultation", "transaction", "booker", "service", "transaction.customer"])
            ->orderBy("created_at", "desc")->paginate(10, ["*"], 'page', $page);

        return [
            'pagination' => [
                'total' => $results->total(),
                'perPage' => $results->perPage(),
                'currentPage' => $results->currentPage(),
                'lastPage' => $results->lastPage(),
            ],
            'data' => array_map(function ($booking) {
                $this->updateStatusToCancelledIfNeeded($booking);
                $this->updateStatusToFailedIfNeeded($booking);
                return $this->createBookingService($booking)->toArray();
            }, $results->items())
        ];
    }

    public function cancel($bookingId, $userId)
    {
        $booking = ServiceBooking::with(["consultation"])->find($bookingId);
        if ($booking) {
            $booking->canceller_id = $userId;
            $booking->status = 'CANCELLED';
            if ($booking->consultation) {
                $booking->consultation->status = 'CANCELLED';
                $booking->consultation->save();
            }
            $booking->save();
        }
    }
    public function checkIfAuthorized($userId, $bookingId)
    {
        $booking = ServiceBooking::find($bookingId);
        return $booking && (($booking->booker_id == $userId) || ($booking->veterinarian_id == $userId));
    }
    public function getById($id)
    {
        $booking = ServiceBooking::with(["consultation", "transaction", "booker", "service"])->find($id);
        $this->updateStatusToCancelledIfNeeded($booking);
        $this->updateStatusToFailedIfNeeded($booking);
        return $booking ? $this->createBookingService($booking) : null;
    }

    public function getByVeterinarianId($veterinarianId, $page = 1)
    {
        $results = ServiceBooking::with(["consultation", "transaction", "booker", "service", "transaction.customer"])
            ->where('veterinarian_id', $veterinarianId)
            ->orderBy("created_at", "desc")->paginate(10);

        return [
            'pagination' => [
                'total' => $results->total(),
                'perPage' => $results->perPage(),
                'currentPage' => $results->currentPage(),
                'lastPage' => $results->lastPage(),
            ],
            'data' => array_map(function ($booking) {
                $this->updateStatusToCancelledIfNeeded($booking);
                $this->updateStatusToFailedIfNeeded($booking);
                return $this->createBookingService($booking)->toArray();
            }, $results->items())
        ];
    }


    public function getByBookerId($bookerId, $page = 1)
    {

        $results = ServiceBooking::with(["consultation", "transaction", "booker", "service", "transaction.customer"])
            ->where('booker_id', $bookerId)
            ->orderBy("created_at", "desc")->paginate(10);

        return [
            'pagination' => [
                'total' => $results->total(),
                'perPage' => $results->perPage(),
                'currentPage' => $results->currentPage(),
                'lastPage' => $results->lastPage(),
            ],
            'data' => array_map(function ($booking) {
                $this->updateStatusToCancelledIfNeeded($booking);
                $this->updateStatusToFailedIfNeeded($booking);
                return $this->createBookingService($booking)->toArray();
            }, $results->items())
        ];
    }

    private function createBookingService($booking)
    {

        $veterinarian = (new VeterinarianRepositoryEloquent())->getById($booking->veterinarian_id);

        $serviceBooking =
            new EntitiesServiceBooking(
                $booking->id,
                $booking->start_time,
                $booking->end_time,
                new User(
                    $booking->booker->id,
                    $booking->booker->name,
                    $booking->booker->email,
                    $booking->booker->created_at,
                    $booking->booker->updated_at,
                    $booking->booker->role,
                    $booking->booker->phone,
                    $booking->booker->username
                ),
                new VetService(
                    $booking->service->id,
                    new VeterinarianShort(
                        $veterinarian->getId(),
                        $veterinarian->getNameAndTitle(),
                        $veterinarian->getUsername(),
                        $veterinarian->getFormalPicturePath(),
                        $veterinarian->getSpecializations(),
                    ),
                    $booking->service->price,
                    $booking->service->duration,
                    $booking->service->description,
                    $booking->service->name,
                ),
                $booking->status,
            );
        if ($booking->transaction) {
            $serviceBooking->setTransaction(
                new Transaction(
                    $booking->transaction->id,
                    $booking->transaction->price,
                    $booking->transaction->platform_fee,
                    new ShortUser(
                        $booking->transaction->customer->id,
                        $booking->transaction->customer->name,
                        $booking->transaction->customer->role
                    ),
                    $booking->transaction->products,
                    $booking->transaction->payment_token,
                    $booking->transaction->status,
                )
            );
        }
        if ($booking->status === 'CANCELLED') {
            $serviceBooking->setCancelledBy(
                $booking->canceller_id == $booking->booker_id
                    ? 'BOOKER' : ($booking->veterinarian_id === $booking->canceller_id
                        ? 'VETERINARIAN' : "SYSTEM")
            );
        }
        return $serviceBooking;
    }

    public function updateStatusByTransactionId($transactionId, $status, $paymentType)
    {
        $booking = ServiceBooking::where('transaction_id', $transactionId)->first();

        if ($booking) {
            $booking->status = $status;
            $booking->payment_type = $paymentType;
            $booking->save();
        }
    }
    public function setTransactionId($bookingId, $transactionId)
    {
        $booking = ServiceBooking::find($bookingId);
        if ($booking) {
            $booking->transaction_id = $transactionId;
            $booking->save();
        }
    }

    public function add(NewBooking $booking)
    {

        $newBooking = new ServiceBooking();
        $newBooking->service_id = $booking->getServiceId();
        $newBooking->start_time = $booking->getStartTime();
        $newBooking->booker_id = $booking->getBookerId();
        $newBooking->veterinarian_id = $booking->getVeterinarianId();
        $newBooking->status = 'PENDING'; // 'CONFIRMED', 'CANCELLED', 'RESCHEDULED'
        $newBooking->save();
        $newBooking->end_time = (new Carbon($booking->getStartTime()))->addMinutes($newBooking->service->duration)->subSecond()->toDateTime();
        $newBooking->save();
        return $this->createBookingService($newBooking);
    }

    public function getByServiceId($serviceId, $page = 1)
    {

        $results = ServiceBooking::with(["consultation", "transaction", "booker", "service", "transaction.customer"])
            ->where('service_id', $serviceId)
            ->orderBy("created_at", "desc")->paginate(10)->items();

        return [
            'pagination' => [
                'total' => $results->total(),
                'perPage' => $results->perPage(),
                'currentPage' => $results->currentPage(),
                'lastPage' => $results->lastPage(),
            ],
            'data' => array_map(function ($booking) {
                return $this->createBookingService($booking)->toArray();
                $this->updateStatusToCancelledIfNeeded($booking);
                $this->updateStatusToFailedIfNeeded($booking);
            }, $results->items())
        ];
    }

    public function updateStatusToCancelledIfNeeded($booking)
    {
        if ($booking->status === 'CANCELLED') return;
        if ($booking->transaction == null) {
            $booking->status = 'CANCELLED';
            $booking->save();
        }
        if ($booking->transaction && $booking->transaction->status === 'CANCELLED') {
            $booking->status = 'CANCELLED';
            $booking->save();
        }
        if ($booking->status === 'PENDING' && $booking->start_time < now()) {
            $booking->status = 'CANCELLED';
            $booking->save();
        }
    }

    public function updateStatusToFailedIfNeeded($booking)
    {
        if ($booking->status === 'FAILED') return;
        if (!$booking->consultation) {
            (new ConsultationRepositoryEloquent())->populate($booking->id);
        }
        if (
            $booking->consultation &&
            ($booking->consultation->status == 'WAITING' || str_ends_with($booking->consultation->status, "ATTENDED") || $booking->consultation->status == 'FAILED')
            && $booking->status === 'CONFIRMED'
            && $booking->end_time < now()
            && !($booking->consultation->veterinarian_attend_at && $booking->consultation->customer_attend_at)
        ) {

            $booking->status = 'FAILED';
            if ($booking->consultation) {
                $consultation = Consultation::find($booking->consultation->id);
                $consultation->status = 'FAILED';
                $booking->consultation->save();
            }

            if ($booking->consultation->veterinarian_attend_at && !$booking->consultation->customer_attend_at) {
                $booking->is_refundable = false;
            }
            if (!$booking->consultation->veterinarian_attend_at && $booking->consultation->customer_attend_at) {
                $booking->is_refundable = true;
            }
            if (!$booking->consultation->customer_attend_at && !$booking->consultation->veterinarian_attend_at) {
                $booking->is_refundable = false;
            }

            $booking->save();
        }
    }

    public function getByVeterinarianIdAndStatus(string $veterinarianId, string $status, $page = 1)
    {

        $results = ServiceBooking::with(["consultation", "transaction", "booker", "service", "transaction.customer"])
            ->where('status', $status)
            ->orderBy("created_at", "desc")->paginate(10);

        return [
            'pagination' => [
                'total' => $results->total(),
                'perPage' => $results->perPage(),
                'currentPage' => $results->currentPage(),
                'lastPage' => $results->lastPage(),
            ],
            'data' => array_map(function ($booking) {
                $this->updateStatusToCancelledIfNeeded($booking);
                $this->updateStatusToFailedIfNeeded($booking);
                return $this->createBookingService($booking)->toArray();
            }, $results->items())
        ];
    }

    public function getByBookerIdAndStatus($bookerId, $status, $page = 1)
    {

        $results = ServiceBooking::with(["consultation", "transaction", "booker", "service", "transaction.customer"])
            ->where('booker_id', $bookerId)
            ->where('status', $status)
            ->orderBy("created_at", "desc")->paginate(10);

        return [
            'pagination' => [
                'total' => $results->total(),
                'perPage' => $results->perPage(),
                'currentPage' => $results->currentPage(),
                'lastPage' => $results->lastPage(),
            ],
            'data' => array_map(function ($booking) {
                return $this->createBookingService($booking)->toArray();
                $this->updateStatusToCancelledIfNeeded($booking);
                $this->updateStatusToFailedIfNeeded($booking);
            }, $results->items())
        ];
    }

    public function getByServiceIdAndStatus($serviceId, $status, $page = 1)
    {
        $results = ServiceBooking::with(["consultation", "transaction", "booker", "service", "transaction.customer"])
            ->where('service_id', $serviceId)
            ->where('status', $status)
            ->orderBy("created_at", "desc")->paginate(10)->items();

        return [
            'pagination' => [
                'total' => $results->total(),
                'perPage' => $results->perPage(),
                'currentPage' => $results->currentPage(),
                'lastPage' => $results->lastPage(),
            ],
            'data' => array_map(function ($booking) {
                return $this->createBookingService($booking)->toArray();
                $this->updateStatusToCancelledIfNeeded($booking);
                $this->updateStatusToFailedIfNeeded($booking);
            }, $results->items())
        ];
    }

    public function checkStatus($bookingId)
    {
        $booking = ServiceBooking::find($bookingId);
        return $booking ? $booking->status : null;
    }

    public function getByStatus($status, $page = 1)
    {
        return ServiceBooking::with(["consultation", "transaction", "booker", "service"])->where('status', $status)
            ->get()
            ->map(function ($booking) {
                $this->updateStatusToCancelledIfNeeded($booking);
                $this->updateStatusToFailedIfNeeded($booking);
                return $this->createBookingService($booking)->toArray();
            });
    }
}
