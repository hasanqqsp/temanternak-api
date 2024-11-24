<?php

namespace App\UseCase\Users;

use App\Domain\Users\UserRepository;

class GetLoyaltyPointByUserIdUseCase
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(string $userId)
    {
        return $this->userRepository->getLoyaltyPointByUserId($userId);
    }
}
