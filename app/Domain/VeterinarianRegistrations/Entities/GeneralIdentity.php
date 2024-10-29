<?php

namespace App\Domain\VeterinarianRegistrations\Entities;

class GeneralIdentity
{
    private string $frontTitle;
    private string $backTitle;
    private \DateTime $dateOfBirth;
    private string $whatsappNumber;
    private string $formalPictureId;
    private string $nik;
    private string $ktpFileId;

    public function __construct(
        string $frontTitle,
        string $backTitle,
        \DateTime $dateOfBirth,
        string $whatsappNumber,
        string $formalPictureId,
        string $nik,
        string $ktpFileId
    ) {
        $this->frontTitle = $frontTitle;
        $this->backTitle = $backTitle;
        $this->dateOfBirth = $dateOfBirth;
        $this->whatsappNumber = $whatsappNumber;
        $this->formalPictureId = $formalPictureId;
        $this->nik = $nik;
        $this->ktpFileId = $ktpFileId;
    }

    public function getFrontTitle(): string
    {
        return $this->frontTitle;
    }

    public function setFrontTitle(string $frontTitle): void
    {
        $this->frontTitle = $frontTitle;
    }

    public function getBackTitle(): string
    {
        return $this->backTitle;
    }

    public function setBackTitle(string $backTitle): void
    {
        $this->backTitle = $backTitle;
    }

    public function getDateOfBirth(): \DateTime
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(\DateTime $dateOfBirth): void
    {
        $this->dateOfBirth = $dateOfBirth;
    }

    public function getWhatsappNumber(): string
    {
        return $this->whatsappNumber;
    }

    public function setWhatsappNumber(string $whatsappNumber): void
    {
        $this->whatsappNumber = $whatsappNumber;
    }

    public function getFormalPictureId(): string
    {
        return $this->formalPictureId;
    }

    public function setFormalPictureId(string $formalPictureId): void
    {
        $this->formalPictureId = $formalPictureId;
    }

    public function getNik(): string
    {
        return $this->nik;
    }

    public function setNik(string $nik): void
    {
        $this->nik = $nik;
    }

    public function getKtpFileId(): string
    {
        return $this->ktpFileId;
    }

    public function setKtpFileId(string $ktpFileId): void
    {
        $this->ktpFileId = $ktpFileId;
    }

    public function toArray(): array
    {
        return [
            'frontTitle' => $this->frontTitle,
            'backTitle' => $this->backTitle,
            'dateOfBirth' => $this->dateOfBirth->format('Y-m-d'),
            'whatsappNumber' => $this->whatsappNumber,
            'formalPictureId' => $this->formalPictureId,
            'nik' => $this->nik,
            'ktpFileId' => $this->ktpFileId,
        ];
    }
}
