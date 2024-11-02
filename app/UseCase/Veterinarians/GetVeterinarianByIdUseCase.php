<?php

namespace App\UseCase\Veterinarians;

use App\Domain\Veterinarians\VeterinarianRepository;

class GetVeterinarianByIdUseCase
{
    private $veterinarianRepository;

    public function __construct(VeterinarianRepository $veterinarianRepository)
    {
        $this->veterinarianRepository = $veterinarianRepository;
    }

    public function execute(string $id)
    {
        return $this->veterinarianRepository->getById($id)->toArray();
    }
}
