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

    public function execute(string $veterinarianId, int  $page = 1)
    {
        return $this->serviceBookingRepository->getByVeterinarianIdAndStatus($veterinarianId, "CONFIRMED", $page);
    }
}
