<?php

namespace App\Domain\Refunds\Entities;

use DateTime;

class NewRefundRequest
{
    private string $oldBookingId;
    private string $newServiceId;
    private string $newBookingId;
    private DateTime $startTime;

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

    public function getNewBookingId(): string
    {
        return $this->newBookingId;
    }

    public function setNewBookingId(string $newBookingId): void
    {
        $this->newBookingId = $newBookingId;
    }

    public function getStartTime(): DateTime
    {
        return $this->startTime;
    }

    public function setStartTime(string $startTime): void
    {
        $this->startTime = new DateTime($startTime);
    }

    public function toArray(): array
    {
        return [
            'oldBookingId' => $this->oldBookingId,
            'newServiceId' => $this->newServiceId,
            'newBookingId' => $this->newBookingId,
            'startTime' => $this->startTime->format("Y-m-d\TH:i:s.up"),
        ];
    }
}
