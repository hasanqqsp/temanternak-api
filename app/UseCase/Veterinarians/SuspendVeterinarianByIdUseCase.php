<?php

namespace App\UseCase\Veterinarians;

use App\Domain\Users\UserRepository;

class SuspendVeterinarianByIdUseCase
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(string $veterinarianId)
    {
        $this->userRepository->suspendVeterinarian($veterinarianId);
    }
}
