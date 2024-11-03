<?php

namespace App\UseCase\VeterinarianServices;

use App\Domain\VeterinarianServices\VeterinarianServiceRepository;

class UnsuspendVeterinarianServiceUseCase
{
    private $repository;

    public function __construct(VeterinarianServiceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $veterinarianId)
    {
        $this->repository->unsuspendService($veterinarianId);
    }
}
