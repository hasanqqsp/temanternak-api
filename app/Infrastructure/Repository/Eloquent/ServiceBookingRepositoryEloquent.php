<?php

namespace App\Infrastructure\Repository\Eloquent;

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
    public function getAll()
    {
        return ServiceBooking::all()->map(function ($booking) {
            return $this->createBookingService($booking);
        });
    }

    public function getById($id)
    {
        $booking = ServiceBooking::find($id);
        return $booking ? $this->createBookingService($booking) : null;
    }

    public function getAllByStatus($status)
    {
        return ServiceBooking::where('status', $status)->get()->map(function ($booking) {
            return $this->createBookingService($booking)->toArray();
        });
    }

    public function getAllByVeterinarianId($veterinarianId)
    {
        return ServiceBooking::where('veterinarian_id', $veterinarianId)->get()->map(function ($booking) {
            return $this->createBookingService($booking)->toArray();
        });
    }

    public function getAllByStatusAndVeterinarianId($status, $veterinarianId)
    {
        return ServiceBooking::where('status', $status)->where('veterinarian_id', $veterinarianId)->get()->map(function ($booking) {
            return $this->createBookingService($booking)->toArray();
        });
    }

    public function getAllByBookerId($bookerId)
    {
        return ServiceBooking::where('booker_id', $bookerId)->get()->map(function ($booking) {
            return $this->createBookingService($booking)->toArray();
        });
    }

    public function getAllByStatusAndBookerId($status, $bookerId)
    {
        return ServiceBooking::where('status', $status)->where('booker_id', $bookerId)->get()->map(function ($booking) {
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
        return $serviceBooking;
    }

    public function updateStatusByTransactionId($transactionId, $status)
    {
        $booking = ServiceBooking::where('transaction_id', $transactionId)->first();
        if ($booking) {
            $booking->status = $status;
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
        $newBooking->end_time = (new Carbon($booking->getStartTime()))->addMinutes($newBooking->service->duration)->toDateTime();
        $newBooking->save();
        return $this->createBookingService($newBooking);
    }


    public function getByVeterinarianId($veterinarianId)
    {
        return ServiceBooking::where('veterinarian_id', $veterinarianId)->get()->map(function ($booking) {
            return $this->createBookingService($booking)->toArray();
        });
    }

    public function getByBookerId($bookerId)
    {
        return ServiceBooking::where('booker_id', $bookerId)->get()->map(function ($booking) {
            return $this->createBookingService($booking)->toArray();
        });
    }

    public function getByServiceId($serviceId)
    {
        return ServiceBooking::where('service_id', $serviceId)->get()->map(function ($booking) {
            return $this->createBookingService($booking)->toArray();
        });
    }

    public function getByTimeRange($startTime, $endTime)
    {
        return ServiceBooking::whereBetween('booking_time', [$startTime, $endTime])->get()->map(function ($booking) {
            return $this->createBookingService($booking)->toArray();
        });
    }
}
