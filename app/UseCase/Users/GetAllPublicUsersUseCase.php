<?php

namespace App\UseCase\Users;

use App\Domain\Users\UserRepository;

class GetAllPublicUsersUseCase
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute()
    {
        return $this->userRepository->getAllPublic();
    }
}
