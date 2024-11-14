<?php

namespace App\UseCase\ServiceBooking;

use App\Domain\ServiceBookings\ServiceBookingRepository;

class GetAllServiceBookingsUseCase
{
    private $serviceBookingRepository;

    public function __construct(ServiceBookingRepository $serviceBookingRepository)
    {
        $this->serviceBookingRepository = $serviceBookingRepository;
    }

    public function execute(int $page = 1)
    {
        return $this->serviceBookingRepository->getAll($page);
    }
}
