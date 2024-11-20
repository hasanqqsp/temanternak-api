<?php

namespace App\UseCase\ServiceBooking;

use App\Domain\ServiceBookings\ServiceBookingRepository;

class GetAllConfirmedServiceBookingsByUserIdUseCase
{
    private $serviceBookingRepository;

    public function __construct(ServiceBookingRepository $serviceBookingRepository)
    {
        $this->serviceBookingRepository = $serviceBookingRepository;
    }

    public function execute(string $userId, string $status, int $page = 1)
    {
        return $this->serviceBookingRepository->getByBookerIdAndStatus($userId, $status, $page);
    }
}
