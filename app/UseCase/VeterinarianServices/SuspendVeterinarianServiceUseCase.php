<?php

namespace App\UseCase\VeterinarianServices;

use App\Domain\VeterinarianServices\VeterinarianServiceRepository;

class SuspendVeterinarianServiceUseCase
{
    private $repository;

    public function __construct(VeterinarianServiceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $id)
    {
        $this->repository->checkIfExist($id);
        $this->repository->suspendService($id);
    }
}
