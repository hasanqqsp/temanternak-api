<?php

namespace App\UseCase\ServiceBooking;

use App\Domain\ServiceBookings\ServiceBookingRepository;

class GetAllServiceBookingsByCustomerIdUseCase
{
    private $serviceBookingRepository;

    public function __construct(ServiceBookingRepository $serviceBookingRepository)
    {
        $this->serviceBookingRepository = $serviceBookingRepository;
    }

    public function execute(string $customerId, int $page = 1)
    {
        return $this->serviceBookingRepository->getByBookerId($customerId, $page);
    }
}
