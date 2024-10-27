<?php

namespace App\UseCase\Users;

use App\Domain\Users\UserRepository;

class DeleteUserUseCase
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(string $userId): bool
    {
        $this->userRepository->verifyUserExist($userId);
        return $this->userRepository->deleteById($userId);
    }
}
