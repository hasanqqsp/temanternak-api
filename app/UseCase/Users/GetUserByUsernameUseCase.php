<?php

namespace App\UseCase\Users;

use App\Domain\Users\UserRepository;

class GetUserByUsernameUseCase
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(string $username)
    {
        return $this->userRepository->getByUsername($username);
    }
}
