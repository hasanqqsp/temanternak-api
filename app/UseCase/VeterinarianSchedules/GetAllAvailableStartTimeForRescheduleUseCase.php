<?php

namespace App\UseCase\VeterinarianSchedules;

use App\Domain\VeterinarianSchedules\VeterinarianScheduleRepository;

class GetAllAvailableStartTimeForRescheduleUseCase
{
    protected $veterinarianScheduleRepository;

    public function __construct(VeterinarianScheduleRepository $veterinarianScheduleRepository)
    {
        $this->veterinarianScheduleRepository = $veterinarianScheduleRepository;
    }

    public function execute($veterinarianId, $bookingId)
    {
        // Fetch all available start times for rescheduling
        $availableStartTimes = $this->veterinarianScheduleRepository->getAvailableStartTimesForReschedule($veterinarianId, 5, 5, $bookingId);

        return $availableStartTimes;
    }
}
