<?php

namespace App\UseCase\Veterinarians;

use App\Domain\VeterinarianRegistrations\Entities\GeneralIdentity;
use App\Domain\Veterinarians\VeterinarianRepository;

class UpdateGeneralIdentityUseCase
{
    protected $veterinarianRepository;

    public function __construct(VeterinarianRepository $veterinarianRepository)
    {
        $this->veterinarianRepository = $veterinarianRepository;
    }

    public function execute(string $id, GeneralIdentity $data)
    {

        $this->veterinarianRepository->checkIfExists($id);
        $veterinarian = $this->veterinarianRepository->updateGeneralIdentity($id, $data);

        return $veterinarian;
    }
}
