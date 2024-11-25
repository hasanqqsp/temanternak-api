<?php

namespace App\UseCase\Users;

use App\Domain\Users\Entities\AddedUser;
use App\Domain\Users\Entities\NewUser;
use App\Domain\Users\UserRepository;

class AddAdminUserUseCase
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(NewUser $userData): AddedUser
    {
        // Add user logic here
        $this->userRepository->verifyEmailAvailable($userData->getEmail());
        $this->userRepository->verifyUsernameAvailable($userData->getUsername());
        $userData->setRole('admin');
        return $this->userRepository->create($userData);
    }
}
