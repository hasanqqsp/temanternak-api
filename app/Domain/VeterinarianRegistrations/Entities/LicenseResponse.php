<?php

namespace App\Domain\VeterinarianRegistrations\Entities;

class LicenseResponse
{
    private string $strvFilePath;
    private string $strvValidUntil;
    private string $strvNumber;
    private string $sipFilePath;
    private string $sipValidUntil;
    private string $sipNumber;
    private string $strvFileId;
    private string $sipFileId;

    public function __construct(string $strvFilePath, string $strvValidUntil, string $strvNumber, string $sipFilePath, string $sipValidUntil, string $sipNumber, string $strvFileId, string $sipFileId)
    {
        $this->strvFilePath = $strvFilePath;
        $this->strvValidUntil = $strvValidUntil;
        $this->strvNumber = $strvNumber;
        $this->sipFilePath = $sipFilePath;
        $this->sipValidUntil = $sipValidUntil;
        $this->sipNumber = $sipNumber;
        $this->strvFileId = $strvFileId;
        $this->sipFileId = $sipFileId;
    }

    public function getStrvFilePath(): string
    {
        return $this->strvFilePath;
    }

    public function getStrvValidUntil(): string
    {
        return $this->strvValidUntil;
    }

    public function getStrvNumber(): string
    {
        return $this->strvNumber;
    }

    public function getSipFilePath(): string
    {
        return $this->sipFilePath;
    }

    public function getSipValidUntil(): string
    {
        return $this->sipValidUntil;
    }

    public function getSipNumber(): string
    {
        return $this->sipNumber;
    }

    public function getStrvFileId(): string
    {
        return $this->strvFileId;
    }

    public function getSipFileId(): string
    {
        return $this->sipFileId;
    }

    public function setStrvFilePath(string $strvFilePath): void
    {
        $this->strvFilePath = $strvFilePath;
    }

    public function setStrvValidUntil(string $strvValidUntil): void
    {
        $this->strvValidUntil = $strvValidUntil;
    }

    public function setStrvNumber(string $strvNumber): void
    {
        $this->strvNumber = $strvNumber;
    }

    public function setSipFilePath(string $sipFilePath): void
    {
        $this->sipFilePath = $sipFilePath;
    }

    public function setSipValidUntil(string $sipValidUntil): void
    {
        $this->sipValidUntil = $sipValidUntil;
    }

    public function setSipNumber(string $sipNumber): void
    {
        $this->sipNumber = $sipNumber;
    }

    public function setStrvFileId(string $strvFileId): void
    {
        $this->strvFileId = $strvFileId;
    }

    public function setSipFileId(string $sipFileId): void
    {
        $this->sipFileId = $sipFileId;
    }

    public function toArray(): array
    {
        return [
            'strvFilePath' => $this->strvFilePath,
            'strvValidUntil' => $this->strvValidUntil,
            'strvNumber' => $this->strvNumber,
            'sipFilePath' => $this->sipFilePath,
            'sipValidUntil' => $this->sipValidUntil,
            'sipNumber' => $this->sipNumber,
            'strvFileId' => $this->strvFileId,
            'sipFileId' => $this->sipFileId,
        ];
    }
}
