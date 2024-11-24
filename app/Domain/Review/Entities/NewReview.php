<?php

namespace App\Domain\Review\Entities;

class NewReview
{
    public string $bookingId;
    public string $review;
    public int $stars;

    public function __construct(string $bookingId, string $review, int $stars)
    {
        $this->bookingId = $bookingId;
        $this->review = $review;
        $this->stars = $stars;
    }

    public function getBookingId(): string
    {
        return $this->bookingId;
    }

    public function setBookingId(string $bookingId): void
    {
        $this->bookingId = $bookingId;
    }

    public function getReview(): string
    {
        return $this->review;
    }

    public function setReview(string $review): void
    {
        $this->review = $review;
    }

    public function getStars(): int
    {
        return $this->stars;
    }

    public function setStars(int $stars): void
    {
        $this->stars = $stars;
    }

    public function toArray(): array
    {
        return [
            'bookingId' => $this->getBookingId(),
            'review' => $this->getReview(),
            'stars' => $this->getStars(),
        ];
    }
}
