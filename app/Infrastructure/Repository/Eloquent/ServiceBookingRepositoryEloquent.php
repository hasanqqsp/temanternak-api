<?php

namespace App\Infrastructure\Repository\Eloquent;

use App\Commons\Exceptions\NotFoundException;
use App\Domain\ServiceBookings\Entities\NewBooking;
use App\Domain\ServiceBookings\Entities\ServiceBooking as EntitiesServiceBooking;
use App\Domain\ServiceBookings\ServiceBookingRepository;
use App\Domain\Transactions\Entities\Transaction;
use App\Domain\Users\Entities\ShortUser;
use App\Domain\Users\Entities\User;
use App\Domain\VeterinarianServices\Entities\VetServiceOnly;
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

    public function checkIfExists($bookingId)
    {
        $booking = ServiceBooking::find($bookingId);
        if (!$booking) {
            throw new NotFoundException("Booking not found");
        }
        return true;
    }

    public function getAll()
    {
        return ServiceBooking::all()->map(function ($booking) {
            return $this->createBookingService($booking);
        });
    }

    public function cancel($bookingId, $userId)
    {
        $booking = ServiceBooking::find($bookingId);
        if ($booking) {
            $booking->canceller_id = $userId;
            $booking->status = 'CANCELLED';
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
        $booking = ServiceBooking::find($id);
        $this->updateStatusToCancelledIfNeeded($booking);
        return $booking ? $this->createBookingService($booking) : null;
    }

    public function getByVeterinarianId($veterinarianId)
    {
        return ServiceBooking::where('veterinarian_id', $veterinarianId)->get()->map(function ($booking) {
            $this->updateStatusToCancelledIfNeeded($booking);

            return $this->createBookingService($booking)->toArray();
        });
    }


    public function getByBookerId($bookerId)
    {
        return ServiceBooking::where('booker_id', $bookerId)->get()->map(function ($booking) {
            $this->updateStatusToCancelledIfNeeded($booking);
            return $this->createBookingService($booking)->toArray();
        });
    }

    private function createBookingService($booking)
    {
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
                new VetServiceOnly(
                    $booking->service->id,
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

    public function getByServiceId($serviceId)
    {
        return ServiceBooking::where('service_id', $serviceId)->get()->map(function ($booking) {
            $this->updateStatusToCancelledIfNeeded($booking);
            return $this->createBookingService($booking)->toArray();
        });
    }

    public function updateStatusToCancelledIfNeeded($booking)
    {
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

    public function getByVeterinarianIdAndStatus(string $veterinarianId, string $status)
    {
        return ServiceBooking::where('veterinarian_id', $veterinarianId)
            ->where('status', $status)
            ->get()
            ->map(function ($booking) {
                $this->updateStatusToCancelledIfNeeded($booking);
                return $this->createBookingService($booking)->toArray();
            });
    }

    public function getByBookerIdAndStatus($bookerId, $status)
    {
        return ServiceBooking::where('booker_id', $bookerId)
            ->where('status', $status)
            ->get()
            ->map(function ($booking) {
                $this->updateStatusToCancelledIfNeeded($booking);
                return $this->createBookingService($booking)->toArray();
            });
    }

    public function getByServiceIdAndStatus($serviceId, $status)
    {
        return ServiceBooking::where('service_id', $serviceId)
            ->where('status', $status)
            ->get()
            ->map(function ($booking) {
                $this->updateStatusToCancelledIfNeeded($booking);
                return $this->createBookingService($booking)->toArray();
            });
    }

    public function checkStatus($bookingId)
    {
        $booking = ServiceBooking::find($bookingId);
        return $booking ? $booking->status : null;
    }

    public function getByStatus($status)
    {
        return ServiceBooking::where('status', $status)
            ->get()
            ->map(function ($booking) {
                $this->updateStatusToCancelledIfNeeded($booking);
                return $this->createBookingService($booking)->toArray();
            });
    }
}
