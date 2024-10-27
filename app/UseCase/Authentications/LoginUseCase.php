<?php

namespace App\UseCase\Authentications;

use App\Commons\Exceptions\ClientException;
use App\Domain\Users\Entities\User;
use App\Domain\Users\UserRepository;
use App\Services\Hash\HashingServiceInterface;

class LoginUseCase
{
    private $userRepository;
    private $hashingService;

    public function __construct(UserRepository $userRepository, HashingServiceInterface $hashingService)
    {
        $this->userRepository = $userRepository;
        $this->hashingService = $hashingService;
    }

    public function execute(string $email, string $password): string
    {
        $this->userRepository->verifyEmailExist($email);
        $hashedPassword = $this->userRepository->getHashedPasswordByEmail($email);
        if ($this->hashingService->check($password, $hashedPassword)) {
            return $this->userRepository->createTokenByEmail($email);
        }
        throw new ClientException('Invalid Credentials');
    }
}
