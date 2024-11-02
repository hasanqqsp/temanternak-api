<?php

namespace App\UseCase\Veterinarians;

use App\Domain\Veterinarians\VeterinarianRepository;

class GetVeterinarianByUsernameUseCase
{
    private $veterinarianRepository;

    public function __construct(VeterinarianRepository $veterinarianRepository)
    {
        $this->veterinarianRepository = $veterinarianRepository;
    }

    public function execute(string $username)
    {
        return $this->veterinarianRepository->getByUsername($username)->toArray();
    }
}
