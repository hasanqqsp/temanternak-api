<?php

namespace App\UseCase\Users;

use App\Domain\User\UserRepository;

class GetAllUsersUseCase
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute()
    {
        return $this->userRepository->findAll();
    }
}
