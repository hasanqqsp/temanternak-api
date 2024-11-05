<?php

namespace App\Domain\ServiceBookings\Entities;

use App\Domain\Transactions\Entities\NewTransaction;
use DateTime;

class NewBooking
{
    private string $serviceId;
    private DateTime $startTime;
    private string $bookerId;
    private string $veterinarianId;

    public function __construct(string $serviceId, string $startTime, string $bookerId, string $veterinarianId)
    {
        $this->serviceId = $serviceId;
        $this->startTime = new DateTime($startTime);
        $this->bookerId = $bookerId;
        $this->veterinarianId = $veterinarianId;
    }

    public function getServiceId(): string
    {
        return $this->serviceId;
    }

    public function getStartTime(): DateTime
    {
        return $this->startTime;
    }

    public function getBookerId(): string
    {
        return $this->bookerId;
    }

    public function getVeterinarianId(): string
    {
        return $this->veterinarianId;
    }
}
