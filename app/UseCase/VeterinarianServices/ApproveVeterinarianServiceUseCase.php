<?php

namespace App\UseCase\VeterinarianServices;

use App\Domain\VeterinarianServices\VeterinarianServiceRepository;

class ApproveVeterinarianServiceUseCase
{
    private $veterinarianServiceRepository;

    public function __construct(VeterinarianServiceRepository $veterinarianServiceRepository)
    {
        $this->veterinarianServiceRepository = $veterinarianServiceRepository;
    }

    public function execute(string $veterinarianServiceId): void
    {
        $this->veterinarianServiceRepository->checkIfExist($veterinarianServiceId);
        $this->veterinarianServiceRepository->approveService($veterinarianServiceId);
    }
}
