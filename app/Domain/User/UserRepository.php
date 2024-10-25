<?php

namespace App\Domain\User;

use App\Domain\User\Entity\AddedUserEntity;
use App\Domain\User\Entity\AddUserEntity;
use App\Domain\User\Entity\UserEntity;

interface UserRepository
{
    public function persist(AddUserEntity $user): AddedUserEntity;
    public function findById(string $id): ?UserEntity;
    public function findAll(): array;
    public function remove(string $id): void;
    public function update(string $id, UserEntity $user): void;
    public function createToken(string $email, string $password): ?string;
}
