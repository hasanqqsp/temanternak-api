<?php

namespace App\UseCase\ServiceBooking;

use App\Domain\ServiceBookings\ServiceBookingRepository;

class GetAllConfirmedServiceBookingsByVeterinarianIdUseCase
{
    private $serviceBookingRepository;

    public function __construct(ServiceBookingRepository $serviceBookingRepository)
    {
        $this->serviceBookingRepository = $serviceBookingRepository;
    }

    public function execute(string $veterinarianId)
    {
        return $this->serviceBookingRepository->getAllByStatusAndVeterinarianId("CONFIRMED", $veterinarianId);
    }
}
