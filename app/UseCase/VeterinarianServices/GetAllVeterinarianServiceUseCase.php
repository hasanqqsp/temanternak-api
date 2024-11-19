<?php

namespace App\UseCase\VeterinarianServices;

use App\Domain\VeterinarianServices\VeterinarianServiceRepository;

class GetAllVeterinarianServiceUseCase
{
    protected $veterinarianServiceRepository;

    public function __construct(VeterinarianServiceRepository $veterinarianServiceRepository)
    {
        $this->veterinarianServiceRepository = $veterinarianServiceRepository;
    }

    public function execute($page = 1)
    {
        return $this->veterinarianServiceRepository->getAll($page);
    }
}
