<?php

namespace App\UseCase\Users;

use App\Domain\Users\Entities\UpdateUser;
use App\Domain\Users\UserRepository;

class UpdateUserUseCase
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(UpdateUser $updateData)
    {
        // Update user in the repository
        $oldUser = $this->userRepository->getById($updateData->getId());
        if (!$oldUser->getEmail() === $updateData->getEmail()) {
            $this->userRepository->verifyEmailAvailable($updateData->getEmail());
        }
        if (!($oldUser->getUsername() === $updateData->getUsername())) {
            $this->userRepository->verifyUsernameAvailable($updateData->getUsername());
        }

        return $this->userRepository->update($updateData);
    }
}
