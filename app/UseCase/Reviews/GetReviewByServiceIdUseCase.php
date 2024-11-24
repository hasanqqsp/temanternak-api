<?php

namespace App\UseCase\Reviews;

use App\Domain\Review\ReviewRepository;

class GetReviewByServiceIdUseCase
{
    private $reviewRepository;

    public function __construct(ReviewRepository $reviewRepository)
    {
        $this->reviewRepository = $reviewRepository;
    }

    public function execute(string $serviceId)
    {
        return $this->reviewRepository->getReviewsByServiceId($serviceId);
    }
}
