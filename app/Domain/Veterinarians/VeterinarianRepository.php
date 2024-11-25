<?php

namespace App\Domain\Veterinarians;

use App\Domain\VeterinarianRegistrations\Entities\BankAndTax;
use App\Domain\VeterinarianRegistrations\Entities\GeneralIdentity;
use App\Domain\VeterinarianRegistrations\Entities\License;
use App\Domain\Veterinarians\Entities\Veterinarian;

interface VeterinarianRepository
{
    public function getById(string $id): Veterinarian;
    public function getByUsername(string $username): Veterinarian;
    public function getAllPublic(): array;
    public function getAllForAdmin(): array;
    public function updateGeneralIdentity(string $id, GeneralIdentity $generalIdentity);
    public function updateSpecializations(string $id, array $specializations);
    public function updateLicense(string $id, License $license);
    public function updateEducations(string $id, array $educations);
    public function updateWorkingExperiences(string $id, array $experiences);
    public function updateOrganizationExperiences(string $id, array $experiences);
    public function updateBankAndTax(string $id, BankAndTax $bankAndTax);
    public function getVeterinarianBankAndTax(string $id): BankAndTax;
    public function getVeterinarianGeneralIdentity(string $id): GeneralIdentity;
    public function getVeterinarianLicense(string $id): License;
    public function getVeterinarianSpecializations(string $id): array;
    public function getVeterinarianEducations(string $id): array;
    public function getVeterinarianWorkingExperiences(string $id): array;
    public function getVeterinarianOrganizationExperiences(string $id): array;
    public function checkIfExists(string $id);
}
