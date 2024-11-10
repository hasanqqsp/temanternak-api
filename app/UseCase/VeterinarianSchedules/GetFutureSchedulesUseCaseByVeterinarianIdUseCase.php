<?php

namespace App\UseCase\VeterinarianSchedules;

use App\Domain\VeterinarianSchedules\VeterinarianScheduleRepository;

class GetFutureSchedulesUseCaseByVeterinarianIdUseCase
{
    private $veterinarianScheduleRepository;

    public function __construct(VeterinarianScheduleRepository $veterinarianScheduleRepository)
    {
        $this->veterinarianScheduleRepository = $veterinarianScheduleRepository;
    }

    public function execute(string $veterinarianId)
    {
        // Fetch future schedules for the given veterinarian ID
        $futureSchedules = $this->veterinarianScheduleRepository->getFutureByVeterinarianId($veterinarianId);

        return $futureSchedules;
    }
}
