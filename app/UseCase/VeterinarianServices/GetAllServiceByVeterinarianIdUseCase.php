<?php

namespace App\UseCase\VeterinarianServices;

use App\Domain\VeterinarianServices\VeterinarianServiceRepository;

class GetAllServiceByVeterinarianIdUseCase
{
    private $veterinarianServiceRepository;

    public function __construct(VeterinarianServiceRepository $veterinarianServiceRepository)
    {
        $this->veterinarianServiceRepository = $veterinarianServiceRepository;
    }

    public function execute(string $veterinarianId)
    {
        // dd($this->veterinarianServiceRepository->getAllByVeterinarianId($veterinarianId));
        return $this->veterinarianServiceRepository->getAllByVeterinarianId($veterinarianId);
    }
}
