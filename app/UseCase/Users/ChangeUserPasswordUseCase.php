<?php

namespace App\UseCase\Users;

use App\Commons\Exceptions\UserInputException;
use App\Domain\Users\Entities\ChangeUserPassword;
use App\Domain\Users\UserRepository;
use App\Services\Hash\HashingServiceInterface;
use Illuminate\Support\Facades\Hash;

class ChangeUserPasswordUseCase
{
    protected $userRepository;
    protected $hash;

    public function __construct(UserRepository $userRepository, HashingServiceInterface $hashingService)
    {
        $this->userRepository = $userRepository;
        $this->hash = $hashingService;
    }

    public function execute(ChangeUserPassword $data): void
    {
        $userId = $data->getUserId();
        $this->userRepository->verifyUserExist($userId);
        $oldPassword = $this->userRepository->getHashedPasswordById($userId);

        if (!hash::check($data->getOldPassword(), $oldPassword)) {
            throw new UserInputException('The old password is incorrect.', [
                "old_password" => 'The old password is incorrect.'
            ]);
        }

        $newHashedPassword = hash::make($data->getNewPassword());
        $this->userRepository->changeUserPassword($userId, $newHashedPassword);
    }
}
