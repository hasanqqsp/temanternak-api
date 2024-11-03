<?php

namespace App\UseCase\VeterinarianServices;

use App\Domain\VeterinarianServices\VeterinarianServiceRepository;

class GetVeterinarianServiceByIdUseCase
{
    private $repository;

    public function __construct(VeterinarianServiceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $id)
    {
        return $this->repository->getById($id);
    }
}
