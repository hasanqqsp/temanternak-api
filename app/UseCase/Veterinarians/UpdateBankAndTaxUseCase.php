<?php

namespace App\UseCase\Veterinarians;

use App\Domain\VeterinarianRegistrations\Entities\BankAndTax;
use App\Domain\Veterinarians\VeterinarianRepository;

class UpdateBankAndTaxUseCase
{
    private $veterinarianRepository;
    public function __construct(VeterinarianRepository $veterinarianRepository)
    {
        $this->veterinarianRepository = $veterinarianRepository;
    }

    public function execute(string $veterinarianId, BankAndTax $data)
    {
        $this->veterinarianRepository->checkIfExists($veterinarianId);
        $this->veterinarianRepository->updateBankAndTax($veterinarianId, $data);
    }
}
