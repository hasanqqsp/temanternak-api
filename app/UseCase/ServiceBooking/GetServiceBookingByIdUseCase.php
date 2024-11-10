<?php

namespace App\UseCase\ServiceBooking;

use App\Domain\ServiceBookings\ServiceBookingRepository;

class GetServiceBookingByIdUseCase
{
    private $serviceBookingRepository;

    public function __construct(ServiceBookingRepository $serviceBookingRepository)
    {
        $this->serviceBookingRepository = $serviceBookingRepository;
    }

    public function execute(string $id, string $credentialId)
    {
        $this->serviceBookingRepository->checkIfExists($id);
        $this->serviceBookingRepository->checkIfAuthorized($id, $credentialId);
        return $this->serviceBookingRepository->getById($id);
    }
}
