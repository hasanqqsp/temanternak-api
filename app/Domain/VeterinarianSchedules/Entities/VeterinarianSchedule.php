<?php

namespace App\Domain\VeterinarianSchedules\Entities;

use DateTime;

class VeterinarianSchedule
{
    private string $id;
    private \DateTime $startTime;
    private \DateTime $endTime;

    public function __construct(string $id, DateTime $startTime, DateTime $endTime)
    {
        $this->id = $id;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getStartTime(): \DateTime
    {
        return $this->startTime;
    }

    public function getEndTime(): \DateTime
    {
        return $this->endTime;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function setStartTime(string $startTime): void
    {
        $this->startTime = new DateTime($startTime);
    }

    public function setEndTime(string $endTime): void
    {
        $this->endTime = new DateTime($endTime);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'startTime' => $this->startTime->format('Y-m-d\TH:i:s.up'),
            'endTime' => $this->endTime->format('Y-m-d\TH:i:s.up'),
        ];
    }
}
