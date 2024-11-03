<?php

namespace App\UseCase\VeterinarianServices;

use App\Domain\VeterinarianServices\Entities\NewService;
use App\Domain\VeterinarianServices\Entities\VetService;
use App\Domain\VeterinarianServices\VeterinarianServiceRepository;

class AddNewVeterinarianServiceUseCase
{
    protected $repository;

    public function __construct(VeterinarianServiceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(NewService $data): VetService
    {
        return $this->repository->add($data);
    }
}
