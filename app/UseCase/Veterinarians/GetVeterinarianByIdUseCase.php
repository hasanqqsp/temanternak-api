<?php

namespace App\UseCase\Veterinarians;

use App\Domain\Veterinarians\VeterinarianRepository;
use App\Domain\VeterinarianSchedules\VeterinarianScheduleRepository;

class GetVeterinarianByIdUseCase
{
    private $veterinarianRepository;
    private $scheduleRepository;

    public function __construct(VeterinarianRepository $veterinarianRepository, VeterinarianScheduleRepository $scheduleRepository)
    {
        $this->veterinarianRepository = $veterinarianRepository;
        $this->scheduleRepository = $scheduleRepository;
    }

    public function execute(string $id)
    {
        $data = $this->veterinarianRepository->getById($id);
        $data->setSchedules($this->scheduleRepository->getNormalizeScheduleByVeterinarianId($id));
        return $data;
    }
}
