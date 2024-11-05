<?php

namespace App\Infrastructure\Repository\Eloquent;

use App\Domain\ServiceBookings\Entities\NewBooking;
use App\Domain\ServiceBookings\Entities\ServiceBooking as EntitiesServiceBooking;
use App\Domain\ServiceBookings\ServiceBookingRepository;
use App\Domain\Users\Entities\ShortUser;
use App\Domain\Users\Entities\User;
use App\Domain\VeterinarianServices\Entities\VetServiceOnly;
use App\Infrastructure\Repository\Models\ServiceBooking;
use Carbon\Carbon;

class ServiceBookingRepositoryEloquent implements ServiceBookingRepository
{

    private function createBookingService($booking)
    {
        return new EntitiesServiceBooking(
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
            return $this->createBookingService($booking);
        });
    }

    public function getByBookerId($bookerId)
    {
        return ServiceBooking::where('booker_id', $bookerId)->get()->map(function ($booking) {
            return $this->createBookingService($booking);
        });
    }

    public function getByServiceId($serviceId)
    {
        return ServiceBooking::where('service_id', $serviceId)->get()->map(function ($booking) {
            return $this->createBookingService($booking);
        });
    }

    public function getByTimeRange($startTime, $endTime)
    {
        return ServiceBooking::whereBetween('booking_time', [$startTime, $endTime])->get()->map(function ($booking) {
            return $this->createBookingService($booking);
        });
    }
}
