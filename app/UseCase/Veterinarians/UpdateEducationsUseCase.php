<?php

namespace App\UseCase\Veterinarians;

use App\Domain\Veterinarians\VeterinarianRepository;

class UpdateEducationsUseCase
{
    protected $veterinarianRepository;

    public function __construct(VeterinarianRepository $veterinarianRepository)
    {
        $this->veterinarianRepository = $veterinarianRepository;
    }

    public function execute(string $veterinarianId, array $educations)
    {
        // Validate the input data
        $this->veterinarianRepository->checkIfExists($veterinarianId);

        // Update the veterinarian's educations
        return $this->veterinarianRepository->updateEducations($veterinarianId, $educations);
    }
}
