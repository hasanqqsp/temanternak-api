<?php

namespace App\UseCase\VeterinarianSchedules;

use App\Domain\ServiceBookings\ServiceBookingRepository;
use App\Domain\VeterinarianSchedules\VeterinarianScheduleRepository;

class GetAllAvailableStartTimeForRescheduleUseCase
{
    protected $veterinarianScheduleRepository;
    protected $serviceBookingRepository;

    public function __construct(VeterinarianScheduleRepository $veterinarianScheduleRepository, ServiceBookingRepository $serviceBookingRepository)
    {
        $this->veterinarianScheduleRepository = $veterinarianScheduleRepository;
        $this->serviceBookingRepository = $serviceBookingRepository;
    }

    public function execute($bookingId)
    {
        $this->serviceBookingRepository->checkIfExists($bookingId);
        $availableStartTimes = $this->veterinarianScheduleRepository->getAvailableStartTimesForReschedule($bookingId, 5, 5);

        return $availableStartTimes;
    }
}
