<?php

namespace App\Domain\VeterinarianRegistrations\Entities;

class AddedVeterinarianRegistration
{
    private string $id;
    private string $status;
    private GeneralIdentity $generalIdentity;
    private License $license;
    private array $specializations;
    private array $educations;
    private array $workingExperiences;
    private array $organizationExperiences;
    private BankAndTax $bankAndTax;

    public function __construct(
        $id,
        $status,
        $generalIdentity,
        $license,
        $specializations,
        $educations,
        $workingExperiences,
        $organizationExperiences,
        $bankAndTax
    ) {
        $this->id = $id;
        $this->status = $status;
        $this->generalIdentity = $generalIdentity;
        $this->license = $license;
        $this->specializations = $specializations;
        $this->educations = $educations;
        $this->workingExperiences = $workingExperiences;
        $this->organizationExperiences = $organizationExperiences;
        $this->bankAndTax = $bankAndTax;
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getGeneralIdentity()
    {
        return $this->generalIdentity;
    }

    public function getLicense()
    {
        return $this->license;
    }

    public function getSpecializations()
    {
        return $this->specializations;
    }

    public function getEducations()
    {
        return $this->educations;
    }

    public function getWorkingExperiences()
    {
        return $this->workingExperiences;
    }

    public function getOrganizationExperiences()
    {
        return $this->organizationExperiences;
    }

    public function getBankAndTax()
    {
        return $this->bankAndTax;
    }

    // Setters
    public function setGeneralIdentity($generalIdentity)
    {
        $this->generalIdentity = $generalIdentity;
    }

    public function setLicense($license)
    {
        $this->license = $license;
    }

    public function setSpecializations($specializations) {}

    public function setBankAndTax($bankAndTax)
    {
        $this->bankAndTax = $bankAndTax;
    }

    // toArray method
    public function toArray()
    {
        $specializations = array_map(function ($specialization) {
            return $specialization->toArray();
        }, $this->getSpecializations());
        $educations = array_map(function ($education) {
            return $education->toArray();
        }, $this->getEducations());
        $workingExperiences = array_map(function ($workingExperience) {
            return $workingExperience->toArray();
        }, $this->getWorkingExperiences());
        $organizationExperiences = array_map(function ($organizationExperiences) {
            return $organizationExperiences->toArray();
        }, $this->getWorkingExperiences());

        return [
            'generalIdentity' => $this->generalIdentity,
            'license' => $this->license,
            'specializations' => $specializations,
            'educations' => $educations,
            'workingExperiences' => $workingExperiences,
            'organizationExperiences' => $organizationExperiences,
            'bankAndTax' => $this->bankAndTax,
        ];
    }
}
