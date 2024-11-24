<?php

namespace App\Domain\Review\Entities;

class VeterinarianReviews
{
    private int $count;
    private float $average;
    private array $reviews;

    public function __construct(int $count = 0, float $average = 0.0, array $reviews = [])
    {
        $this->count = $count;
        $this->average = $average;
        $this->reviews = $reviews;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function setCount(int $count): void
    {
        $this->count = $count;
    }

    public function getAverage(): float
    {
        return $this->average;
    }

    public function setAverage(float $average): void
    {
        $this->average = $average;
    }

    public function getReviews(): array
    {
        return $this->reviews;
    }

    public function setReviews(array $reviews): void
    {
        $this->reviews = $reviews;
    }

    public function addReview($review): void
    {
        $this->reviews[] = $review;
        $this->count = count($this->reviews);
        $this->average = array_sum(array_column($this->reviews, 'rating')) / $this->count;
    }
    public function toArray(): array
    {
        return [
            'count' => $this->count,
            'average' => $this->average,
            'reviews' => $this->reviews,
        ];
    }
}
