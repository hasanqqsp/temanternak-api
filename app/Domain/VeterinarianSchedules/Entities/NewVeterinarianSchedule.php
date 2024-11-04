<?php

namespace App\Domain\VeterinarianSchedules\Entities;

use DateTime;

class NewVeterinarianSchedule
{
    private string $veterinarianId;
    private DateTime $startTime;
    private DateTime $endTime;

    public function __construct(string $veterinarianId, string $startTime, string $endTime)
    {
        $this->veterinarianId = $veterinarianId;
        $this->startTime = new DateTime($startTime);
        $this->endTime = new DateTime($endTime);
    }

    public function getVeterinarianId(): string
    {
        return $this->veterinarianId;
    }

    public function getStartTime(): DateTime
    {
        return $this->startTime;
    }

    public function getEndTime(): DateTime
    {
        return $this->endTime;
    }

    public function toArray(): array
    {
        return [
            'veterinarianId' => $this->veterinarianId,
            'startTime' => $this->startTime->format('Y-m-d H:i:s'),
            'endTime' => $this->endTime->format('Y-m-d H:i:s'),
        ];
    }

    public function getDiff(): int
    {
        $interval = $this->startTime->diff($this->endTime);
        return (($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i) + 1;
    }
}
