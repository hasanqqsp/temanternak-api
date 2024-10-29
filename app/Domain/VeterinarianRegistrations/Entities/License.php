<?php

namespace App\Domain\VeterinarianRegistrations\Entities;

class License
{
    private string $strvFileId;
    private string $strvValidUntil;
    private string $strvNumber;
    private string $sipFileId;
    private string $sipValidUntil;
    private string $sipNumber;

    public function __construct(string $strvFileId, string $strvValidUntil, string $strvNumber, string $sipFileId, string $sipValidUntil, string $sipNumber)
    {
        $this->strvFileId = $strvFileId;
        $this->strvValidUntil = $strvValidUntil;
        $this->strvNumber = $strvNumber;
        $this->sipFileId = $sipFileId;
        $this->sipValidUntil = $sipValidUntil;
        $this->sipNumber = $sipNumber;
    }

    public function getStrvFileId(): string
    {
        return $this->strvFileId;
    }

    public function getStrvValidUntil(): string
    {
        return $this->strvValidUntil;
    }

    public function getStrvNumber(): string
    {
        return $this->strvNumber;
    }

    public function getSipFileId(): string
    {
        return $this->sipFileId;
    }

    public function getSipValidUntil(): string
    {
        return $this->sipValidUntil;
    }

    public function getSipNumber(): string
    {
        return $this->sipNumber;
    }

    public function setStrvFileId(string $strvFileId): void
    {
        $this->strvFileId = $strvFileId;
    }

    public function setStrvValidUntil(string $strvValidUntil): void
    {
        $this->strvValidUntil = $strvValidUntil;
    }

    public function setStrvNumber(string $strvNumber): void
    {
        $this->strvNumber = $strvNumber;
    }

    public function setSipFileId(string $sipFileId): void
    {
        $this->sipFileId = $sipFileId;
    }

    public function setSipValidUntil(string $sipValidUntil): void
    {
        $this->sipValidUntil = $sipValidUntil;
    }

    public function setSipNumber(string $sipNumber): void
    {
        $this->sipNumber = $sipNumber;
    }

    public function toArray(): array
    {
        return [
            'strvFileId' => $this->strvFileId,
            'strvValidUntil' => $this->strvValidUntil,
            'strvNumber' => $this->strvNumber,
            'sipFileId' => $this->sipFileId,
            'sipValidUntil' => $this->sipValidUntil,
            'sipNumber' => $this->sipNumber,
        ];
    }
}
