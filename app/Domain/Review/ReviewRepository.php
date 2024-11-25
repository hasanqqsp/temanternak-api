<?php

namespace App\Domain\Review;

use App\Domain\Review\Entities\NewReview;

interface ReviewRepository
{
    public function addReview(NewReview $data);
    public function getReviewsByVeterinarianId($veterinarianId);
    public function getAllReviews();
    public function getReviewsByServiceId($serviceId);
    public function getReviewByBookingId($bookingId);
    public function checkIfExistsByBookingId($bookingId);
    public function checkIfNotExistsByBookingId($bookingId);
    public function getAverageRatingByVeterinarianId($veterinarianId);
}
