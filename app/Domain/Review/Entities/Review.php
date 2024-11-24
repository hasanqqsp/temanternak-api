<?php

namespace App\Domain\Review\Entities;

class Review
{
    private $review;
    private $stars;

    public function __construct($review, $stars)
    {
        $this->review = $review;
        $this->stars = $stars;
    }

    public function getReview()
    {
        return $this->review;
    }

    public function getStars()
    {
        return $this->stars;
    }

    public function setReview($review)
    {
        $this->review = $review;
    }

    public function setStars($stars)
    {
        $this->stars = $stars;
    }
    public function toArray()
    {
        return [
            'review' => $this->review,
            'stars' => $this->stars,
        ];
    }
}
