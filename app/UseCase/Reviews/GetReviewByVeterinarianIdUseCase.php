<?php

namespace App\UseCase\Reviews;

use App\Domain\Review\ReviewRepository;

class GetReviewByVeterinarianIdUseCase
{
    private $reviewRepository;

    public function __construct(ReviewRepository $reviewRepository)
    {
        $this->reviewRepository = $reviewRepository;
    }

    public function execute(string $veterinarianId)
    {
        return $this->reviewRepository->getReviewsByVeterinarianId($veterinarianId);
    }
}
