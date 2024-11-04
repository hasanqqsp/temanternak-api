<?php

namespace App\UseCase\VeterinarianSchedules;

use App\Domain\VeterinarianSchedules\VeterinarianScheduleRepository;


class RemoveVeterinarianScheduleUseCase
{
    private $veterinarianScheduleRepository;

    public function __construct(VeterinarianScheduleRepository $veterinarianScheduleRepository)
    {
        $this->veterinarianScheduleRepository = $veterinarianScheduleRepository;
    }

    public function execute(string $scheduleId, $credentialsId)
    {
        $this->veterinarianScheduleRepository->checkIfExist($scheduleId);
        $this->veterinarianScheduleRepository->verifyOwnership($scheduleId, $credentialsId);

        return $this->veterinarianScheduleRepository->remove($scheduleId);
    }
}
