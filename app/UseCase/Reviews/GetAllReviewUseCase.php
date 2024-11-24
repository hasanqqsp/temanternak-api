<?php

namespace App\UseCase\Reviews;

use App\Domain\Review\ReviewRepository;

class GetAllReviewUseCase
{
    protected $reviewRepository;

    public function __construct(ReviewRepository $reviewRepository)
    {
        $this->reviewRepository = $reviewRepository;
    }

    public function execute()
    {
        return $this->reviewRepository->getAllReviews();
    }
}
