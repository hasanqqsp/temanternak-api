<?php

namespace App\UseCase\Dashboards;

use App\Domain\Review\ReviewRepository;
use App\Domain\ServiceBookings\ServiceBookingRepository;
use App\Domain\Users\UserRepository;

class GetVeterinarianDashboardUseCase
{
    private $reviewRepository;
    private $serviceBookingRepository;

    public function __construct(ReviewRepository $reviewRepository, ServiceBookingRepository $serviceBookingRepository)
    {
        $this->reviewRepository = $reviewRepository;
        $this->serviceBookingRepository = $serviceBookingRepository;
    }
    public function execute($veterinarianId)
    {
        return [
            "totalTransactions" => $this->serviceBookingRepository->getTotalTransactionsByVeterinarianId($veterinarianId),
            "totalTransactionsAmount" => $this->serviceBookingRepository->getTotalTransactionsAmountByVeterinarianId($veterinarianId),
            "averageRating" => $this->reviewRepository->getAverageRatingByVeterinarianId($veterinarianId),
            "totalBookingToday" => $this->serviceBookingRepository->getTotalBookingTodayByVeterinarianId($veterinarianId),
        ];
    }
}
