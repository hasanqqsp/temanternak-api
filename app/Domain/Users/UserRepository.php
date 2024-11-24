<?php

namespace App\Domain\Users;

use App\Domain\Users\Entities\AddedUser;
use App\Domain\Users\Entities\NewUser;
use App\Domain\Users\Entities\UpdateUser;
use App\Domain\Users\Entities\User;

interface UserRepository
{
    public function create(NewUser $userData): AddedUser;
    public function deleteById(string $id): bool;
    public function update(UpdateUser $userData): bool;
    public function verifyEmailExist(string $email);
    public function verifyEmailAvailable(string $email): void;
    public function verifyUsernameAvailable(string $username): void;
    public function verifyUserExist(string $id): void;
    public function verifyUsernameExist(string $username): void;
    public function getById(string $id): User;
    public function getByEmail(string $email): User;
    public function getByUsername(string $username): User;
    public function getByRole(string $role): array;
    public function getAllPublic(): array;
    public function getAll(): array;
    public function changeUserPassword(string $id, string $hashedPassword): void;
    public function getHashedPasswordById(string $id): string;
    public function getHashedPasswordByEmail(string $id): string;
    public function createTokenByEmail(string $email): string;
    public function changeRole(string $id, string $role): void;
    public function removeAllToken(string $id): void;
    public function getWalletByUserId(string $id): float;
    public function getLoyaltyPointByUserId(string $id): int;
}
