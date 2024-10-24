<?php

namespace App\Infrastructure\Repository\Eloquent;

use App\Domain\Users\Entities\NewUser;
use App\Domain\Users\UserRepository;
use App\Infrastructure\Repository\Models\User;
use Hidehalo\Nanoid\Client;

class UserRepositoryEloquent implements UserRepository
{
    private $nanoid;

    public function __construct()
    {
        $this->nanoid = new Client();
    }

    public function findById(string $id)
    {
        return User::find($id);
    }
    public function findAll()
    {
        return User::all();
    }
    public function create(NewUser $user)
    {
        $userModel = new User();
        $userModel->name = $user->getName();
        $userModel->email = $user->getEmail();
        $userModel->password = $user->getPassword();
        $userModel->role = $user->getRole();
        $userModel->save();
        return $userModel;
    }
    public function deleteUserById(int $id)
    {
        return User::destroy($id);
    }
}
