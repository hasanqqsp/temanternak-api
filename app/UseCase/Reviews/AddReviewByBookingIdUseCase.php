<?php

namespace App\UseCase\Reviews;

use App\Commons\Exceptions\ClientException;
use App\Domain\Review\Entities\NewReview;
use App\Domain\Review\ReviewRepository;
use App\Domain\ServiceBookings\ServiceBookingRepository;

class AddReviewByBookingIdUseCase
{
    protected $reviewRepository;
    protected $bookingRepository;

    public function __construct(ReviewRepository $reviewRepository, ServiceBookingRepository $bookingRepository)
    {
        $this->reviewRepository = $reviewRepository;
        $this->bookingRepository = $bookingRepository;
    }

    public function execute(NewReview $reviewData, $credentialId)
    {
        // Validate booking ID
        $this->bookingRepository->checkIfExists($reviewData->getBookingId());
        $this->bookingRepository->checkIfAuthorized($reviewData->getBookingId(), $credentialId);
        $this->reviewRepository->checkIfNotExistsByBookingId($reviewData->getBookingId());

        if ($this->bookingRepository->checkStatus($reviewData->getBookingId()) !== "COMPLETED") {
            throw new ClientException("Consultation not yet completed");
        };
        // Add review
        $review = $this->reviewRepository->addReview($reviewData);

        return $review;
    }
}
