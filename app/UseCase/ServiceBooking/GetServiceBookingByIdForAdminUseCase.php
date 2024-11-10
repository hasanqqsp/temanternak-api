<?php

namespace App\UseCase\ServiceBooking;

use App\Domain\ServiceBookings\ServiceBookingRepository;

class GetServiceBookingByIdForAdminUseCase
{
    private $serviceBookingRepository;

    public function __construct(ServiceBookingRepository $serviceBookingRepository)
    {
        $this->serviceBookingRepository = $serviceBookingRepository;
    }

    public function execute(string $id)
    {
        $this->serviceBookingRepository->checkIfExists($id);
        return $this->serviceBookingRepository->getById($id);
    }
}
