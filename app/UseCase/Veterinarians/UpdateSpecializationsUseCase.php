<?php

namespace App\UseCase\Veterinarians;

use App\Domain\Veterinarians\VeterinarianRepository;

class UpdateSpecializationsUseCase
{
    private $veterinarianRepository;
    public function __construct(VeterinarianRepository $veterinarianRepository)
    {
        $this->veterinarianRepository = $veterinarianRepository;
    }

    public function execute(string $veterinarianId, array $specializationIds)
    {
        $this->veterinarianRepository->checkIfExists($veterinarianId);
        return $this->veterinarianRepository->updateSpecializations($veterinarianId, $specializationIds);
    }
}
