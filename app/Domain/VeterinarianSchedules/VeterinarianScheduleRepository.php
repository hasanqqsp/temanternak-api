<?php

namespace App\Domain\VeterinarianSchedules;

use App\Domain\VeterinarianSchedules\Entities\NewVeterinarianSchedule;
use App\Domain\VeterinarianSchedules\Entities\VeterinarianSchedule;
use DateTime;

interface VeterinarianScheduleRepository
{
    public function add(NewVeterinarianSchedule $data): VeterinarianSchedule;
    public function getByVeterinarianId(string $veterinarianId): array;
    public function remove(string $id);
    public function verifyOwnership(string $scheduleId, string $veterinarianId);
    public function checkIfExist(string $id);
    public function checkIsNotOverlapping(string $veterinarianId, DateTime $startTime, DateTime $endTime);
    public function getNormalizeScheduleByVeterinarianId(string $veterinarianId);
}
