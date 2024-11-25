<?php

namespace App\UseCase\Veterinarians;

use App\Domain\Users\UserRepository;

class UnsuspendVeterinarianByIdUseCase
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(string $veterinarianId)
    {
        $this->userRepository->unsuspendVeterinarian($veterinarianId);
    }
}
