<?php

namespace App\Domain\Refunds\Entities;

use App\Domain\ServiceBookings\Entities\ServiceBooking;
use App\Domain\Transactions\Entities\Transaction;
use DateTime;

class RefundRequest
{
    private string $oldBookingId;
    private string $newServiceId;
    private string $refundType;
    private string $status;
    private ServiceBooking $newBooking;

    public function __construct(
        string $oldBookingId,
        string $newServiceId,
        string $refundType,
        string $status,
        ServiceBooking $newBooking,
    ) {
        $this->oldBookingId = $oldBookingId;
        $this->newServiceId = $newServiceId;
        $this->refundType = $refundType;
        $this->status = $status;
        $this->newBooking = $newBooking;
    }

    public function getOldBookingId(): string
    {
        return $this->oldBookingId;
    }

    public function setOldBookingId(string $oldBookingId): void
    {
        $this->oldBookingId = $oldBookingId;
    }

    public function getNewServiceId(): string
    {
        return $this->newServiceId;
    }

    public function setNewServiceId(string $newServiceId): void
    {
        $this->newServiceId = $newServiceId;
    }

    public function getRefundType(): string
    {
        return $this->refundType;
    }

    public function setRefundType(string $refundType): void
    {
        $this->refundType = $refundType;
    }


    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getNewBooking(): ServiceBooking
    {
        return $this->newBooking;
    }

    public function setNewBooking(ServiceBooking $newBooking): void
    {
        $this->newBooking = $newBooking;
    }


    public static $REFUND_TYPE = [
        'FULL_REFUND' => 'FULL_REFUND',
        'REBOOK_WITH_REFUND' => 'REBOOK_WITH_REFUND',
        'REBOOK_WITHOUT_REFUND' => 'REBOOK_WITHOUT_REFUND',
        'REBOOK_WITH_ADDED_COST' => 'REBOOK_WITH_ADDED_COST',
    ];
    public function toArray(): array
    {
        return [
            'oldBookingId' => $this->oldBookingId,
            'newServiceId' => $this->newServiceId,
            'refundType' => $this->refundType,
            'status' => $this->status,
            'newBooking' => $this->newBooking->toArray(),
        ];
    }
}
