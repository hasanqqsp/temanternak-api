<?php

namespace App\Domain\Consultations\Entities;

use DateTime;

class Consultation
{
    private string $id;
    private string $serviceName;
    private string $veterinarianNameAndTitle;
    private string $veterinarianId;
    private DateTime $startTime;
    private DateTime $endTime;
    private int $duration;
    private string $bookerName;
    private string $bookerId;
    private string $status;
    private ?array $callLogs;
    private ?array $chatLogs;
    private ?string $result;
    private ?DateTime $veterinarianAttendAt;
    private ?DateTime $customerAttendAt;

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

    public function getBookerName(): string
    {
        return $this->bookerName;
    }

    public function setBookerName(string $bookerName): void
    {
        $this->bookerName = $bookerName;
    }

    public function getBookerId(): string
    {
        return $this->bookerId;
    }

    public function setBookerId(string $bookerId): void
    {
        $this->bookerId = $bookerId;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getCallLogs(): ?array
    {
        return $this->callLogs;
    }

    public function setCallLogs(?array $callLogs): void
    {
        $this->callLogs = $callLogs;
    }

    public function getChatLogs(): ?array
    {
        return $this->chatLogs;
    }

    public function setChatLogs(?array $chatLogs): void
    {
        $this->chatLogs = $chatLogs;
    }

    public function getResult(): ?string
    {
        return $this->result;
    }

    public function setResult(?string $result): void
    {
        $this->result = $result;
    }

    public function getVeterinarianAttendAt(): ?DateTime
    {
        return $this->veterinarianAttendAt;
    }

    public function setVeterinarianAttendAt(?DateTime $veterinarianAttendAt): void
    {
        $this->veterinarianAttendAt = $veterinarianAttendAt;
    }

    public function getCustomerAttendAt(): ?DateTime
    {
        return $this->customerAttendAt;
    }

    public function setCustomerAttendAt(?DateTime $customerAttendAt): void
    {
        $this->customerAttendAt = $customerAttendAt;
    }

    public function __construct(
        string $id,
        string $serviceName,
        string $veterinarianNameAndTitle,
        string $veterinarianId,
        DateTime $startTime,
        DateTime $endTime,
        int $duration,
        string $bookerName,
        string $bookerId,
        string $status,
        ?array $callLogs = null,
        ?array $chatLogs = null,
        ?string $result = null,
        ?DateTime $veterinarianAttendAt = null,
        ?DateTime $customerAttendAt = null
    ) {
        $this->id = $id;
        $this->serviceName = $serviceName;
        $this->veterinarianNameAndTitle = $veterinarianNameAndTitle;
        $this->veterinarianId = $veterinarianId;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->duration = $duration;
        $this->bookerName = $bookerName;
        $this->bookerId = $bookerId;
        $this->status = $status;
        $this->callLogs = $callLogs;
        $this->chatLogs = $chatLogs;
        $this->result = $result;
        $this->veterinarianAttendAt = $veterinarianAttendAt;
        $this->customerAttendAt = $customerAttendAt;
    }

    public function toArray(): array
    {
        $array = [
            'id' => $this->id,
            'serviceName' => $this->serviceName,
            'veterinarianNameAndTitle' => $this->veterinarianNameAndTitle,
            'veterinarianId' => $this->veterinarianId,
            'startTime' => $this->startTime->format('Y-m-d\TH:i:s.up'),
            'endTime' => $this->endTime->format('Y-m-d\TH:i:s.up'),
            'duration' => $this->duration,
            'bookerName' => $this->bookerName,
            'bookerId' => $this->bookerId,
            'status' => $this->status,
        ];

        if ($this->callLogs !== null) {
            $array['callLogs'] = $this->callLogs;
        }

        if ($this->chatLogs !== null) {
            $array['chatLogs'] = $this->chatLogs;
        }

        if ($this->result !== null) {
            $array['result'] = $this->result;
        }

        if ($this->veterinarianAttendAt !== null) {
            $array['veterinarianAttendAt'] = $this->veterinarianAttendAt->format('Y-m-d\TH:i:s.up');
        }

        if ($this->customerAttendAt !== null) {
            $array['customerAttendAt'] = $this->customerAttendAt->format('Y-m-d\TH:i:s.up');
        }

        return $array;
    }
}
