<?php

namespace App\Domain\ServiceBookings;

use App\Domain\ServiceBookings\Entities\NewBooking;

interface ServiceBookingRepository
{
    public function add(NewBooking $newBooking);
    public function getByVeterinarianId(string $id);
    public function getByBookerId(string $id);
    public function getByServiceId(string $id);
    public function getByTimeRange(string $startTime, string $endTime);
    public function setTransactionId(string $bookingId, string $transactionId);
}
