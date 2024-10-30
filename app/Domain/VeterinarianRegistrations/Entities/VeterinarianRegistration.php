<?php

namespace App\Domain\VeterinarianRegistrations\Entities;

use App\Domain\Invitations\Entities\Invitation;
use App\Domain\Users\Entities\User;
use DateTime;

class VeterinarianRegistration
{
    private string $id;
    private string $status;
    private User $user;
    private string $frontTitle;
    private string $backTitle;
    private \DateTime $dateOfBirth;
    private string $whatsappNumber;
    private string $formalPictureFilePath;
    private string $nik;
    private string $ktpFilePath;
    private string $createdAt;
    private string $updatedAt;
    private array $specializations;
    private LicenseResponse $license;
    private array $educations;
    private array $workingExperiences;
    private array $organizationExperiences;
    private BankAndTaxResponse $bankAndTax;
    private Invitation $invitation;
    private string $biodata;

    public function __construct(
        string $id,
        string $status,
        User $user,
        string $frontTitle,
        string $backTitle,
        string $dateOfBirth,
        string $whatsappNumber,
        string $formalPictureFilePath,
        string $nik,
        string $ktpFilePath,
        string $createdAt,
        string $updatedAt,
        array $specializations,
        LicenseResponse $license,
        array $educations,
        array $workingExperiences,
        array $organizationExperiences,
        BankAndTaxResponse $bankAndTax,
        Invitation $invitation,
        string $biodata
    ) {
        $this->id = $id;
        $this->status = $status;
        $this->user = $user;
        $this->frontTitle = $frontTitle;
        $this->backTitle = $backTitle;
        $this->dateOfBirth = new \DateTime($dateOfBirth);
        $this->whatsappNumber = $whatsappNumber;
        $this->formalPictureFilePath = $formalPictureFilePath;
        $this->nik = $nik;
        $this->ktpFilePath = $ktpFilePath;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->specializations = $specializations;
        $this->license = $license;
        $this->educations = $educations;
        $this->workingExperiences = $workingExperiences;
        $this->organizationExperiences = $organizationExperiences;
        $this->bankAndTax = $bankAndTax;
        $this->invitation = $invitation;
        $this->biodata = $biodata;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
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

    public function setDateOfBirth(string $dateOfBirth): void
    {
        $this->dateOfBirth = new DateTime($dateOfBirth);
    }

    public function getWhatsappNumber(): string
    {
        return $this->whatsappNumber;
    }

    public function setWhatsappNumber(string $whatsappNumber): void
    {
        $this->whatsappNumber = $whatsappNumber;
    }

    public function getFormalPictureFilePath(): string
    {
        return $this->formalPictureFilePath;
    }

    public function setFormalPictureFilePath(string $formalPictureFilePath): void
    {
        $this->formalPictureFilePath = $formalPictureFilePath;
    }

    public function getNik(): string
    {
        return $this->nik;
    }

    public function setNik(string $nik): void
    {
        $this->nik = $nik;
    }

    public function getKtpFilePath(): string
    {
        return $this->ktpFilePath;
    }

    public function setKtpFilePath(string $ktpFilePath): void
    {
        $this->ktpFilePath = $ktpFilePath;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getSpecializations(): array
    {
        return $this->specializations;
    }

    public function setSpecializations(array $specializations): void
    {
        $this->specializations = $specializations;
    }

    public function getLicense(): LicenseResponse
    {
        return $this->license;
    }

    public function setLicense(License $license): void
    {
        $this->license = $license;
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

    public function getBankAndTax(): BankAndTaxResponse
    {
        return $this->bankAndTax;
    }

    public function setBankAndTax(BankAndTax $bankAndTax): void
    {
        $this->bankAndTax = $bankAndTax;
    }

    public function getInvitation(): Invitation
    {
        return $this->invitation;
    }

    public function setInvitation(Invitation $invitation): void
    {
        $this->invitation = $invitation;
    }

    public function getBiodata(): string
    {
        return $this->biodata;
    }

    public function setBiodata(string $biodata): void
    {
        $this->biodata = $biodata;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'user' => $this->user->toArray(),
            'frontTitle' => $this->frontTitle,
            'backTitle' => $this->backTitle,
            'dateOfBirth' => $this->dateOfBirth->format('Y-m-d'),
            'whatsappNumber' => $this->whatsappNumber,
            'formalPictureFilePath' => $this->formalPictureFilePath,
            'nik' => $this->nik,
            'ktpFilePath' => $this->ktpFilePath,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
            'specializations' => $this->specializations,
            'license' => $this->license->toArray(),
            'educations' => array_map(function ($education) {
                return $education->toArray();
            }, $this->getEducations()),
            'workingExperiences' => array_map(function ($workingExperience) {
                return $workingExperience->toArray();
            }, $this->getWorkingExperiences()),
            'organizationExperiences' => array_map(function ($organizationExperience) {
                return $organizationExperience->toArray();
            }, $this->getOrganizationExperiences()),
            'bankAndTax' => $this->bankAndTax->toArray(),
            'invitation' => $this->invitation->toArray(),
            'biodata' => $this->biodata,
        ];
    }
}
