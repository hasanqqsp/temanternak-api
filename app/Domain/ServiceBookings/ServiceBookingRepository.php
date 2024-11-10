<?php

namespace App\Domain\ServiceBookings;

use App\Domain\ServiceBookings\Entities\NewBooking;

interface ServiceBookingRepository
{
    public function add(NewBooking $newBooking);
    public function getAll();
    public function getById(string $id);
    public function getByVeterinarianId(string $id);
    public function getByBookerId(string $id);
    public function getByServiceId(string $id);
    public function getByVeterinarianIdAndStatus(string $id, string $status);
    public function getByBookerIdAndStatus(string $id, string $status);
    public function getByServiceIdAndStatus(string $id, string $status);
    public function getByStatus(string $status);
    public function setTransactionId(string $bookingId, string $transactionId);
    public function updateStatusByTransactionId(string $transactionId, string $status);
    public function checkIfAuthorized(string $bookingId, string $userId);
    public function cancel(string $bookingId, string $userId);
    public function checkIfExists(string $bookingId);
    public function checkStatus(string $bookingId);
}
