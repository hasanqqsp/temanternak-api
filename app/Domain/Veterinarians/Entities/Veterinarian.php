<?php

namespace App\Domain\Veterinarians\Entities;

class Veterinarian
{
    public string $id;
    public string $nameAndTitle;
    public string $strvNumber;
    public string $strvValidUntil;
    public string $sipNumber;
    public string $sipValidUntil;
    public string $registeredAt;
    public string $username;
    public string $formalPicturePath;
    public array $specializations;
    public array $educations;
    public array $workingExperiences;
    public array $organizationExperiences;
    public string $biodata;
    public array $services;

    public function __construct(
        string $id,
        string $nameAndTitle,
        string $strvNumber,
        string $strvValidUntil,
        string $sipNumber,
        string $sipValidUntil,
        string $registeredAt,
        string $username,
        string $formalPicturePath,
        array $specializations,
        array $educations,
        array $workingExperiences,
        array $organizationExperiences,
        string $biodata,
        array $services
    ) {
        $this->id = $id;
        $this->nameAndTitle = $nameAndTitle;
        $this->strvNumber = $strvNumber;
        $this->strvValidUntil = $strvValidUntil;
        $this->sipNumber = $sipNumber;
        $this->sipValidUntil = $sipValidUntil;
        $this->registeredAt = $registeredAt;
        $this->username = $username;
        $this->formalPicturePath = $formalPicturePath;
        $this->specializations = $specializations;
        $this->educations = $educations;
        $this->workingExperiences = $workingExperiences;
        $this->organizationExperiences = $organizationExperiences;
        $this->biodata = $biodata;
        $this->services = $services;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getNameAndTitle(): string
    {
        return $this->nameAndTitle;
    }

    public function setNameAndTitle(string $nameAndTitle): void
    {
        $this->nameAndTitle = $nameAndTitle;
    }

    public function getStrvNumber(): string
    {
        return $this->strvNumber;
    }

    public function setStrvNumber(string $strvNumber): void
    {
        $this->strvNumber = $strvNumber;
    }

    public function getStrvValidUntil(): string
    {
        return $this->strvValidUntil;
    }

    public function setStrvValidUntil(string $strvValidUntil): void
    {
        $this->strvValidUntil = $strvValidUntil;
    }

    public function getSipNumber(): string
    {
        return $this->sipNumber;
    }

    public function setSipNumber(string $sipNumber): void
    {
        $this->sipNumber = $sipNumber;
    }

    public function getSipValidUntil(): string
    {
        return $this->sipValidUntil;
    }

    public function setSipValidUntil(string $sipValidUntil): void
    {
        $this->sipValidUntil = $sipValidUntil;
    }

    public function getRegisteredAt(): string
    {
        return $this->registeredAt;
    }

    public function setRegisteredAt(string $registeredAt): void
    {
        $this->registeredAt = $registeredAt;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getFormalPicturePath(): string
    {
        return $this->formalPicturePath;
    }

    public function setFormalPicturePath(string $formalPicturePath): void
    {
        $this->formalPicturePath = $formalPicturePath;
    }

    public function getSpecializations(): array
    {
        return $this->specializations;
    }

    public function setSpecializations(array $specializations): void
    {
        $this->specializations = $specializations;
    }

    public function getEducations(): array
    {
        return $this->educations;
    }

    public function setEducations(array $educations): void
    {
        $this->educations = $educations;
    }

    public function getWorkingExperiences(): array
    {
        return $this->workingExperiences;
    }

    public function setWorkingExperiences(array $workingExperiences): void
    {
        $this->workingExperiences = $workingExperiences;
    }

    public function getOrganizationExperiences(): array
    {
        return $this->organizationExperiences;
    }

    public function setOrganizationExperiences(array $organizationExperiences): void
    {
        $this->organizationExperiences = $organizationExperiences;
    }

    public function getBiodata(): string
    {
        return $this->biodata;
    }

    public function setBiodata(string $biodata): void
    {
        $this->biodata = $biodata;
    }

    public function getServices(): array
    {
        return $this->services;
    }

    public function setServices(array $services): void
    {
        $this->services = $services;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nameAndTitle' => $this->nameAndTitle,
            'strvNumber' => $this->strvNumber,
            'strvValidUntil' => $this->strvValidUntil,
            'sipNumber' => $this->sipNumber,
            'sipValidUntil' => $this->sipValidUntil,
            'registeredAt' => $this->registeredAt,
            'username' => $this->username,
            'formalPicturePath' => $this->formalPicturePath,
            'specializations' => $this->specializations,
            'educations' => $this->educations,
            'workingExperiences' => $this->workingExperiences,
            'organizationExperiences' => $this->organizationExperiences,
            'biodata' => $this->biodata,
            'services' => $this->services,
        ];
    }
}
