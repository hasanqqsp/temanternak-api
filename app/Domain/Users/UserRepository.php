<?php

namespace App\Domain\Users;

use App\Domain\Users\Entities\NewUser;

interface UserRepository
{
    public function findById(string $id);
    public function findAll();
    public function create(NewUser $user);
    public function deleteUserById(int $id);
}
