<?php

namespace App\UseCase\Veterinarians;

use App\Domain\Veterinarians\VeterinarianRepository;

class GetSpecializationsForUpdateUseCase
{
    private VeterinarianRepository $veterinarianRepository;
    public function __construct(VeterinarianRepository $veterinarianRepository)
    {
        $this->veterinarianRepository = $veterinarianRepository;
    }
    public function execute(string $veterinarianId)
    {
        $this->veterinarianRepository->checkIfExists($veterinarianId);
        return $this->veterinarianRepository->getVeterinarianSpecializations($veterinarianId);
    }
}
