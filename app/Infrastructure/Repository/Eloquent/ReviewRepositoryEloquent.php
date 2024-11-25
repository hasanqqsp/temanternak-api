<?php

namespace App\Infrastructure\Repository\Eloquent;

use App\Commons\Exceptions\NotFoundException;
use App\Domain\Review\Entities\NewReview;
use App\Domain\Review\Entities\Review as EntitiesReview;
use App\Domain\Review\Entities\VeterinarianReviews;
use App\Domain\Review\ReviewRepository;
use App\Infrastructure\Repository\Models\Review;
use App\Infrastructure\Repository\Models\ServiceBooking;
use App\Infrastructure\Repository\Models\User;

class ReviewRepositoryEloquent implements ReviewRepository
{
    public function getReviewByBookingId($bookingId)
    {
        $review = Review::where("booking_id", $bookingId)->first();
        if ($review) {
            return new EntitiesReview(
                $review->review,
                $review->stars
            );
        }
    }
    public function checkIfNotExistsByBookingId($bookingId)
    {
        if (!Review::where("booking_id", $bookingId)->doesntExist()) {
            throw new NotFoundException("Review with booking ID {$bookingId} already exists.");
        }
    }

    public function checkIfExistsByBookingId($bookingId)
    {
        if (!Review::where("booking_id", $bookingId)->exists()) {
            throw new NotFoundException("Review with booking ID {$bookingId} does not exist.");
        }
    }


    public function addReview(NewReview $reviewData)
    {
        $review = new Review();
        $review->review = $reviewData->getReview();
        $review->booking_id = $reviewData->getBookingId();
        $review->stars = $reviewData->getStars();
        $review->save();
    }

    public function getReviewsByVeterinarianId($veterinarianId)
    {
        $user = User::find($veterinarianId);

        $reviews = Review::whereIn("booking_id", $user->bookings->pluck("id"))->get();
        return new VeterinarianReviews(
            $reviews->count(),
            $reviews->avg('stars'),
            $reviews->map(fn($review) => (new EntitiesReview(
                $review->review,
                $review->stars
            ))->toArray())->toArray()
        );
    }

    public function getAllReviews()
    {
        return Review::get()->map(fn($review) => (new EntitiesReview(
            $review->review,
            $review->stars
        ))->toArray());
    }

    public function getReviewsByServiceId($serviceId)
    {
        $bookingsIds = ServiceBooking::where("service_id", $serviceId)->pluck("id");
        return Review::whereIn("booking_id", $bookingsIds)->get()
            ->map(fn($review) => (new EntitiesReview(
                $review->review,
                $review->stars
            ))->toArray());
    }
}
