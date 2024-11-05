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
    public function updateStatusByTransactionId(string $transactionId, string $status);
    public function getAll();
    public function getById(string $id);
    public function getAllByStatus(string $status);
    public function getAllByVeterinarianId(string $veterinarianId);
    public function getAllByStatusAndVeterinarianId(string $status, string $veterinarianId);
    public function getAllByBookerId(string $bookerId);
    public function getAllByStatusAndBookerId(string $status, string $bookerId);
}
