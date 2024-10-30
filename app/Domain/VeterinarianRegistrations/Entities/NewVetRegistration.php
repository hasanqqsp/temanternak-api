<?php

namespace App\Domain\VeterinarianRegistrations\Entities;

class NewVetRegistration
{
    private GeneralIdentity $generalIdentity;
    private License $license;
    private array $specializations;
    private array $educations;
    private array $workingExperiences;
    private array $organizationExperiences;
    private BankAndTax $bankAndTax;
    private string $invitationId;
    private string $userId;

    public function __construct(
        $generalIdentity,
        $license,
        $specializations,
        $educations,
        $workingExperiences,
        $organizationExperiences,
        $bankAndTax,
        string $invitationId,
        string $userId
    ) {
        $this->generalIdentity = $generalIdentity;
        $this->license = $license;
        $this->specializations = $specializations;
        $this->educations = $educations;
        $this->workingExperiences = $workingExperiences;
        $this->organizationExperiences = $organizationExperiences;
        $this->bankAndTax = $bankAndTax;
        $this->invitationId = $invitationId;
        $this->userId = $userId;
    }

    // Getters
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

    public function getInvitationId()
    {
        return $this->invitationId;
    }

    public function getUserId()
    {
        return $this->userId;
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

    public function setSpecializations($specializations)
    {
        $this->specializations = $specializations;
    }

    public function setEducations($educations)
    {
        $this->educations = $educations;
    }

    public function setWorkingExperiences($workingExperiences)
    {
        $this->workingExperiences = $workingExperiences;
    }

    public function setOrganizationExperiences($organizationExperiences)
    {
        $this->organizationExperiences = $organizationExperiences;
    }

    public function setBankAndTax($bankAndTax)
    {
        $this->bankAndTax = $bankAndTax;
    }

    public function setInvitationId(string $invitationId)
    {
        $this->invitationId = $invitationId;
    }

    public function setUserId(string $userId)
    {
        $this->userId = $userId;
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
            'invitationId' => $this->invitationId,
            'userId' => $this->userId,
        ];
    }
}
