<?php

namespace App\UseCase\VeterinarianServices;

use App\Domain\VeterinarianServices\VeterinarianServiceRepository;

class DeleteVeterinarianServiceUseCase
{
    private $veterinarianServiceRepository;

    public function __construct(VeterinarianServiceRepository $veterinarianServiceRepository)
    {
        $this->veterinarianServiceRepository = $veterinarianServiceRepository;
    }

    public function execute(string $serviceId, $credentialsId)
    {
        $this->veterinarianServiceRepository->checkIfExist($serviceId);
        $this->veterinarianServiceRepository->verifyOwnership($serviceId, $credentialsId);
        return $this->veterinarianServiceRepository->deleteById($serviceId);
    }
}
