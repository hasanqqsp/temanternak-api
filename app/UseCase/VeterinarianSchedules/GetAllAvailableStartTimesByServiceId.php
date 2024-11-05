<?php

namespace App\UseCase\VeterinarianSchedules;

use App\Domain\VeterinarianSchedules\VeterinarianScheduleRepository;
use App\Domain\VeterinarianServices\VeterinarianServiceRepository;

class GetAllAvailableStartTimesByServiceId
{
    protected $veterinarianScheduleRepository;
    protected $veterinarianServiceRepository;

    public function __construct(VeterinarianScheduleRepository $veterinarianScheduleRepository, VeterinarianServiceRepository $veterinarianServiceRepository)
    {
        $this->veterinarianScheduleRepository = $veterinarianScheduleRepository;
        $this->veterinarianServiceRepository = $veterinarianServiceRepository;
    }

    public function execute(string $serviceId): array
    {
        $this->veterinarianServiceRepository->checkIfExist($serviceId);

        $availableStartTimes = $this->veterinarianScheduleRepository->getAvailableStartTimes($serviceId, 5, 5);

        return $availableStartTimes;
    }
}
