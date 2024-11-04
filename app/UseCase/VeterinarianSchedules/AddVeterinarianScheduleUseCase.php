<?php

namespace App\UseCase\VeterinarianSchedules;

use App\Commons\Exceptions\ClientException;
use App\Domain\VeterinarianSchedules\Entities\NewVeterinarianSchedule;
use App\Domain\VeterinarianSchedules\VeterinarianScheduleRepository;

class AddVeterinarianScheduleUseCase
{
    private VeterinarianScheduleRepository $veterinarianScheduleRepository;
    public function __construct(VeterinarianScheduleRepository $veterinarianScheduleRepository)
    {
        $this->veterinarianScheduleRepository = $veterinarianScheduleRepository;
    }
    public function execute(NewVeterinarianSchedule $data)
    {
        if ($data->getDiff() < 20) {
            throw new ClientException('The duration between start and end time must be at least 20 minutes.');
        }

        $this->veterinarianScheduleRepository->checkIsNotOverlapping(
            $data->getVeterinarianId(),
            $data->getStartTime(),
            $data->getEndTime()
        );

        return $this->veterinarianScheduleRepository->add($data);
    }
}
