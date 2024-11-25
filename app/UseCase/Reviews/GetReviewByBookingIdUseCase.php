<?php

namespace App\UseCase\Reviews;

use App\Domain\Review\ReviewRepository;

class GetReviewByBookingIdUseCase
{
    private $reviewRepository;

    public function __construct(ReviewRepository $reviewRepository)
    {
        $this->reviewRepository = $reviewRepository;
    }

    public function execute(string $bookingId)
    {
        $this->reviewRepository->checkIfExistsByBookingId($bookingId);
        return $this->reviewRepository->getReviewByBookingId($bookingId);
    }
}
