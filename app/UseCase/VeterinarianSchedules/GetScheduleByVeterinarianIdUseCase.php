<?php

namespace App\UseCase\VeterinarianSchedules;

use App\Domain\VeterinarianSchedules\VeterinarianScheduleRepository;

class GetScheduleByVeterinarianIdUseCase
{
    protected $veterinarianScheduleRepository;

    public function __construct(VeterinarianScheduleRepository $veterinarianScheduleRepository)
    {
        $this->veterinarianScheduleRepository = $veterinarianScheduleRepository;
    }

    public function execute(string $veterinarianId)
    {
        return $this->veterinarianScheduleRepository->getAllByVeterinarianId($veterinarianId);
    }
}
