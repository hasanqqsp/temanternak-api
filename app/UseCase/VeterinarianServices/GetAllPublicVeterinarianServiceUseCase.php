<?php

namespace App\UseCase\VeterinarianServices;

use App\Domain\VeterinarianServices\VeterinarianServiceRepository;

class GetAllPublicVeterinarianServiceUseCase
{
    private $veterinarianServiceRepository;

    public function __construct(VeterinarianServiceRepository $veterinarianServiceRepository)
    {
        $this->veterinarianServiceRepository = $veterinarianServiceRepository;
    }

    public function execute()
    {
        return $this->veterinarianServiceRepository->getAllPublic();
    }
}
