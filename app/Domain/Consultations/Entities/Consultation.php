<?php

namespace App\Domain\Consultations\Entities;

use DateTime;

class Consultation
{
    private string $id;
    private string $serviceName;
    private string $veterinarianNameAndTitle;
    private DateTime $startTime;
    private DateTime $endTime;
    private int $duration;
    private string $bookerName;
    private string $status;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getServiceName(): string
    {
        return $this->serviceName;
    }

    public function setServiceName(string $serviceName): void
    {
        $this->serviceName = $serviceName;
    }

    public function getVeterinarianNameAndTitle(): string
    {
        return $this->veterinarianNameAndTitle;
    }

    public function setVeterinarianNameAndTitle(string $veterinarianNameAndTitle): void
    {
        $this->veterinarianNameAndTitle = $veterinarianNameAndTitle;
    }

    public function getStartTime(): DateTime
    {
        return $this->startTime;
    }

    public function setStartTime(DateTime $startTime): void
    {
        $this->startTime = $startTime;
    }

    public function getEndTime(): DateTime
    {
        return $this->endTime;
    }

    public function setEndTime(DateTime $endTime): void
    {
        $this->endTime = $endTime;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): void
    {
        $this->duration = $duration;
    }

    public function getBookerName(): string
    {
        return $this->bookerName;
    }

    public function setBookerName(string $bookerName): void
    {
        $this->bookerName = $bookerName;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function __construct(
        string $id,
        string $serviceName,
        string $veterinarianNameAndTitle,
        DateTime $startTime,
        DateTime $endTime,
        int $duration,
        string $bookerName,
        string $status
    ) {
        $this->id = $id;
        $this->serviceName = $serviceName;
        $this->veterinarianNameAndTitle = $veterinarianNameAndTitle;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->duration = $duration;
        $this->bookerName = $bookerName;
        $this->status = $status;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'serviceName' => $this->serviceName,
            'veterinarianNameAndTitle' => $this->veterinarianNameAndTitle,
            'startTime' => $this->startTime->format('Y-m-d\TH:i:s.up'),
            'endTime' => $this->endTime->format('Y-m-d\TH:i:s.up'),
            'duration' => $this->duration,
            'bookerName' => $this->bookerName,
            'status' => $this->status,
        ];
    }
}
