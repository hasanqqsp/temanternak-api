<?php

namespace App\Domain\Consultations\Entities;

use App\Domain\Consultations\SIPCredential;
use DateTime;

class NewConsultation
{
    private string $serviceId;
    private string $veterinarianId;
    private DateTime $startTime;
    private DateTime $endTime;
    private int $duration;
    private string $bookerId;
    private SIPCredential $sipCredential;
    private string $status;

    public function getServiceId(): string
    {
        return $this->serviceId;
    }

    public function setServiceId(string $serviceId): void
    {
        $this->serviceId = $serviceId;
    }

    public function getVeterinarianId(): string
    {
        return $this->veterinarianId;
    }

    public function setVeterinarianId(string $veterinarianId): void
    {
        $this->veterinarianId = $veterinarianId;
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

    public function getBookerId(): string
    {
        return $this->bookerId;
    }

    public function setBookerId(string $bookerId): void
    {
        $this->bookerId = $bookerId;
    }

    public function getSipCredential(): SIPCredential
    {
        return $this->sipCredential;
    }

    public function setSipCredential(SIPCredential $sipCredential): void
    {
        $this->sipCredential = $sipCredential;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }
}
