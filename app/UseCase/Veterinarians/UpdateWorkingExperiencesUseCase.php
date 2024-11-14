<?php

namespace App\UseCase\Veterinarians;

use App\Domain\Veterinarians\VeterinarianRepository;

class UpdateWorkingExperiencesUseCase
{
    private $veterinarianRepository;
    public function __construct(VeterinarianRepository $veterinarianRepository)
    {
        $this->veterinarianRepository = $veterinarianRepository;
    }

    public function execute(string $veterinarianId, array $workingExperiences)
    {
        $this->veterinarianRepository->checkIfExists($veterinarianId);
        $this->veterinarianRepository->updateWorkingExperiences($veterinarianId, $workingExperiences);
    }
}
