<?php

namespace App\UseCase\Users;

use App\Domain\User\UserRepository;

class GetUserByIdUseCase
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(int $userId)
    {
        return $this->userRepository->findById($userId);
    }
}
