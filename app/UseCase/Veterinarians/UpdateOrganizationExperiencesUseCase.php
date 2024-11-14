<?php

namespace App\UseCase\Veterinarians;

use App\Domain\Veterinarians\VeterinarianRepository;

class UpdateOrganizationExperiencesUseCase
{

    private $veterinarianRepository;
    public function __construct(VeterinarianRepository $veterinarianRepository)
    {
        $this->veterinarianRepository = $veterinarianRepository;
    }

    public function execute(string $veterinarianId, array $experiences)
    {
        $this->veterinarianRepository->checkIfExists($veterinarianId);
        return $this->veterinarianRepository->updateOrganizationExperiences($veterinarianId, $experiences);
    }
}
