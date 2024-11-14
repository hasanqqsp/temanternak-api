<?php

namespace App\UseCase\Veterinarians;

use App\Domain\Veterinarians\VeterinarianRepository;

class GetBankAndTaxForUpdateUseCase
{
    protected $veterinarianRepository;

    public function __construct(VeterinarianRepository $veterinarianRepository)
    {
        $this->veterinarianRepository = $veterinarianRepository;
    }

    public function execute(string $veterinarianId)
    {
        // Fetch the veterinarian's bank and tax information for update
        $this->veterinarianRepository->checkIfExists($veterinarianId);
        return $this->veterinarianRepository->getVeterinarianBankAndTax($veterinarianId);
    }
}
