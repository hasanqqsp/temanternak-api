<?php

namespace App\Infrastructure\Repository\Eloquent;

use App\Domain\Users\Entities\NewUser;
use App\Domain\Users\Entities\User as UserEntity;
use App\Domain\Users\UserRepository;
use App\Infrastructure\Repository\Models\User;

class UserRepositoryEloquent implements UserRepository
{

    public function __construct() {}

    public function findById(string $id)
    {
        return User::find($id);
    }
    public function findAll(): array
    {
        $allUsers = User::all()->toArray();
        $mappedUsers = array_map(function ($user) {
            return new UserEntity($user["id"], $user["name"], $user["email"], $user["created_at"], $user["updated_at"]);
        }, $allUsers);
        return $mappedUsers;
    }
    public function create(NewUser $user): string
    {
        $userModel = new User();
        $userModel->name = $user->getName();
        $userModel->email = $user->getEmail();
        $userModel->password = $user->getPassword();
        $userModel->role = $user->getRole();
        $userModel->save();
        return $userModel->id;
    }
    public function deleteUserById(int $id): string
    {
        return User::destroy($id);
    }
}
