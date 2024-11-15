<?php

namespace App\Domain\ServiceBookings;

use App\Domain\ServiceBookings\Entities\NewBooking;

interface ServiceBookingRepository
{
    public function add(NewBooking $newBooking);
    public function getAll(int $page);
    public function getById(string $id);
    public function getByVeterinarianId(string $id, int $page);
    public function getByBookerId(string $id, int $page);
    public function getByServiceId(string $id, int $page);
    public function getByVeterinarianIdAndStatus(string $id, string $status, int $page);
    public function getByBookerIdAndStatus(string $id, string $status, int $page);
    public function getByServiceIdAndStatus(string $id, string $status, int $page);
    public function getByStatus(string $status, int $page);
    public function setTransactionId(string $bookingId, string $transactionId);
    public function updateStatusByTransactionId(string $transactionId, string $status, string $paymentType);
    public function checkIfAuthorized(string $bookingId, string $userId);
    public function cancel(string $bookingId, string $userId);
    public function checkIfExists(string $bookingId);
    public function checkStatus(string $bookingId);
    public function reschedule(string $bookingId, string $newStartTime);
    public function checkIsRefundable(string $bookingId);
    public function setRebookingId(string $bookingId, string $rebookingId);
}
