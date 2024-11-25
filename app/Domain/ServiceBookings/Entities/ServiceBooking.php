<?php

namespace App\Domain\ServiceBookings\Entities;

use App\Domain\Review\Entities\Review;
use App\Domain\Transactions\Entities\Transaction;
use App\Domain\Users\Entities\User;
use App\Domain\VeterinarianServices\Entities\VetService;

use DateTime;

class ServiceBooking
{
    private string $id;
    private DateTime $startTime;
    private DateTime $endTime;
    private User $booker;
    private VetService $service;
    private ?Transaction $transaction;
    private string $status;
    private ?string $cancelledBy;
    private ?Review $review; // Update the type hinting to Review
    private ?bool $isRefundable;

    public function __construct(string $id, DateTime $startTime, DateTime $endTime, User $booker, VetService $service, string $status, ?Transaction $transaction = null, ?string $cancelledBy = null, ?Review $review = null, ?bool $isRefundable = null)
    {
        $this->id = $id;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->booker = $booker;
        $this->service = $service;
        $this->transaction = $transaction;
        $this->status = $status;
        $this->cancelledBy = $cancelledBy;
        $this->review = $review;
        $this->isRefundable = $isRefundable;
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

    public function getService(): VetService
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

    public function getCancelledBy(): ?string
    {
        return $this->cancelledBy;
    }

    public function getReview(): ?Review // Update the return type to Review
    {
        return $this->review;
    }

    public function getIsRefundable(): ?bool
    {
        return $this->isRefundable;
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

    public function setService(VetService $service): void
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

    public function setCancelledBy(?string $cancelledBy): void
    {
        $this->cancelledBy = $cancelledBy;
    }

    public function setReview(?Review $review): void // Update the parameter type to Review
    {
        $this->review = $review;
    }

    public function setIsRefundable(?bool $isRefundable): void
    {
        $this->isRefundable = $isRefundable;
    }

    public function toArray(): array
    {
        $data = [
            'id' => $this->id,
            'startTime' => $this->startTime->format('Y-m-d\TH:i:s.up'),
            'endTime' => $this->endTime->format('Y-m-d\TH:i:s.up'),
            'booker' => $this->booker->toArray(),
            'service' => $this->service->toArray(),
            'transaction' => $this->transaction ? $this->transaction->toArray() : null,
            'status' => $this->status,
            'review' => $this->review ? $this->review->toArray() : null, // Update to call toArray on Review

        ];

        if ($this->cancelledBy !== null) {
            $data['cancelledBy'] = $this->cancelledBy;
        }
        if ($this->isRefundable !== null) {
            $data['isRefundable'] = $this->isRefundable;
        }

        return $data;
    }
}
