<?php

namespace App\UseCase\Veterinarians;

use App\Domain\Veterinarians\VeterinarianRepository;

class GetOrganizationExperiencesForUpdateUseCase
{
    protected $organizationExperienceRepository;

    public function __construct(VeterinarianRepository $organizationExperienceRepository)
    {
        $this->organizationExperienceRepository = $organizationExperienceRepository;
    }

    public function execute(string $veterinarianId)
    {
        $this->organizationExperienceRepository->checkIfExists($veterinarianId);
        return $this->organizationExperienceRepository->getVeterinarianOrganizationExperiences($veterinarianId);
    }
}
