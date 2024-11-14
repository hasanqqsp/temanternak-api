<?php

namespace App\UseCase\Veterinarians;

use App\Domain\VeterinarianRegistrations\Entities\License;
use App\Domain\Veterinarians\VeterinarianRepository;

class UpdateLicenseUseCase
{
    private $veterinarianRepository;
    public function __construct(VeterinarianRepository $veterinarianRepository)
    {
        $this->veterinarianRepository = $veterinarianRepository;
    }


    public function execute(string $veterinarianId, License $newLicense)
    {
        $this->veterinarianRepository->checkIfExists($veterinarianId);
        $this->veterinarianRepository->updateLicense($veterinarianId, $newLicense);
    }
}
