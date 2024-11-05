<?php

namespace App\Domain\ServiceBookings\Entities;

use App\Domain\Transactions\Entities\Transaction;
use App\Domain\Users\Entities\User;
use App\Domain\VeterinarianServices\Entities\VetServiceOnly;
use DateTime;

class ServiceBooking
{
    private string $id;
    private DateTime $startTime;
    private DateTime $endTime;
    private User $booker;
    private VetServiceOnly $service;
    private ?Transaction $transaction;
    private string $status;

    public function __construct(string $id, DateTime $startTime, DateTime $endTime, User $booker, VetServiceOnly $service, string $status, ?Transaction $transaction = null)
    {
        $this->id = $id;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->booker = $booker;
        $this->service = $service;
        $this->transaction = $transaction;
        $this->status = $status;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getStartTime(): DateTime
    {
        return $this->startTime;
    }

    public function getEndTime(): DateTime
    {
        return $this->endTime;
    }

    public function getBooker(): User
    {
        return $this->booker;
    }

    public function getService(): VetServiceOnly
    {
        return $this->service;
    }

    public function getTransaction(): ?Transaction
    {
        return $this->transaction;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function setStartTime(DateTime $startTime): void
    {
        $this->startTime = $startTime;
    }

    public function setEndTime(DateTime $endTime): void
    {
        $this->endTime = $endTime;
    }

    public function setBooker(User $booker): void
    {
        $this->booker = $booker;
    }

    public function setService(VetServiceOnly $service): void
    {
        $this->service = $service;
    }

    public function setTransaction(?Transaction $transaction): void
    {
        $this->transaction = $transaction;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'startTime' => $this->startTime->format('Y-m-d\TH:i:s.up'),
            'endTime' => $this->endTime->format('Y-m-d\TH:i:s.up'),
            'booker' => $this->booker->toArray(),
            'service' => $this->service->toArray(),
            'transaction' => $this->transaction ? $this->transaction->toArray() : null,
            'status' => $this->status,
        ];
    }
}
