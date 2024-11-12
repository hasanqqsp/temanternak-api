<?php

namespace App\Infrastructure\Repository\Eloquent;

use App\Commons\Exceptions\NotFoundException;
use App\Commons\Exceptions\UserInputException;
use App\Domain\Users\Entities\AddedUser;
use App\Domain\Users\Entities\NewUser;
use App\Domain\Users\Entities\UpdateUser;
use App\Domain\Users\Entities\User as UserEntity;
use App\Domain\Users\UserRepository;
use App\Infrastructure\Repository\Models\Settlement;
use App\Infrastructure\Repository\Models\User;


class UserRepositoryEloquent implements UserRepository
{
    public function removeAllToken(string $userId): void
    {
        $user = User::find($userId);
        if ($user) {
            $user->tokens()->delete();
        }
    }
    public function getWalletByUserId(string $userId): float
    {
        $user = User::find($userId);

        Settlement::where('veterinarian_id', $userId)
            ->where('status', 'PENDING')
            ->get()->map(function ($settlement) use ($user) {
                $oldBalance = $user->balance;
                $user->deposit("veterinarian_wallet", $settlement->accepted_amount, $settlement->id);
                if (($user->balance - $settlement->amount_accepted) != $oldBalance) {
                    $settlement->status = 'COMPLETED';
                    $settlement->save();
                }
            });
        return $user->walletBalance;
    }
    public function deleteById(string $id): bool
    {
        return User::destroy($id) > 0;
    }

    public function update(UpdateUser $user): bool
    {
        $userModel = User::find($user->getId());
        if ($userModel) {
            $userModel->name = $user->getName();
            $userModel->email = $user->getEmail();
            $userModel->role = $user->getRole();
            $userModel->phone = $user->getPhone();
            $userModel->username = $user->getUsername();
            return $userModel->save();
        }
        return false;
    }

    public function verifyEmailAvailable(string $email): void
    {
        if (User::where('email', $email)->exists()) {
            throw new UserInputException("Email is already in use.", [
                "email" => "Email is already in use."
            ]);
        }
    }

    public function verifyUsernameAvailable(string $username): void
    {
        if (User::where('username', $username)->exists()) {
            throw new UserInputException("Username is already in use.", [
                "username" => "Username is already in use."
            ]);
        }
    }

    public function verifyUserExist(string $id): void
    {
        if (!User::where('id', $id)->exists()) {
            throw new NotFoundException("User does not exist.");
        }
    }

    public function verifyUsernameExist(string $username): void
    {
        if (!User::where('username', $username)->exists()) {
            throw new NotFoundException("Username does not exist.");
        }
    }

    public function getByEmail(string $email): UserEntity
    {
        $user = User::where('email', $email)->first();
        return $user ? new UserEntity(
            $user["id"],
            $user["name"],
            $user["email"],
            $user["created_at"],
            $user["updated_at"],
            $user["role"],
            $user["phone"],
            $user["username"]
        ) : null;
    }

    public function getByUsername(string $username): UserEntity
    {
        $user = User::where('username', $username)->first();
        return $user ?  new UserEntity(
            $user["id"],
            $user["name"],
            $user["email"],
            $user["created_at"],
            $user["updated_at"],
            $user["role"],
            $user["phone"],
            $user["username"]
        ) : null;
    }

    public function getByRole(string $role): array
    {
        $users = User::where('role', $role)->get()->toArray();
        return array_map(function ($user) {
            return new UserEntity(
                $user["id"],
                $user["name"],
                $user["email"],
                $user["created_at"],
                $user["updated_at"],
                $user["role"],
                $user["phone"],
                $user["username"]
            );
        }, $users);
    }

    public function getAllPublic(): array
    {
        $users = User::where('is_public', true)->get()->toArray();
        return array_map(function ($user) {
            return new UserEntity(
                $user["id"],
                $user["name"],
                $user["email"],
                $user["created_at"],
                $user["updated_at"],
                $user["role"],
                $user["phone"],
                $user["username"]
            );
        }, $users);
    }

    public function getAll(): array
    {
        $users = User::all()->toArray();
        return array_map(function ($user) {
            return (new UserEntity(
                $user["id"],
                $user["name"],
                $user["email"],
                $user["created_at"],
                $user["updated_at"],
                $user["role"],
                $user["phone"],
                $user["username"]
            ))->toArray();
        }, $users);
    }

    public function __construct() {}

    public function getById(string $id): UserEntity
    {
        $user = User::find($id);
        if (!$user) {
            throw new NotFoundException("User does not exist.");
        }
        return new UserEntity(
            $user["id"],
            $user["name"],
            $user["email"],
            $user["created_at"],
            $user["updated_at"],
            $user["role"],
            $user["phone"],
            $user["username"]
        );
    }

    public function create(NewUser $user): AddedUser
    {
        $userModel = new User();
        $userModel->name = $user->getName();
        $userModel->email = $user->getEmail();
        $userModel->password = $user->getPassword();
        $userModel->role = $user->getRole();
        $userModel->phone = $user->getPhone();
        $userModel->username = $user->getUsername();
        $userModel->save();
        return new AddedUser($userModel->id, $userModel->created_at);
    }
    public function changeUserPassword(string $id, string $newPassword): void
    {
        $user = User::find($id);

        $user->password = $newPassword;
        $user->save();
    }

    public function deleteUserById(string $id): string
    {
        return User::destroy($id);
    }

    public function getHashedPasswordById(string $id): string
    {
        $user = User::find($id);
        return $user->password;
    }
    public function getHashedPasswordByEmail(string $email): string
    {
        $user = User::where("email", $email)->first();
        return $user->password;
    }

    public function verifyEmailExist(string $email)
    {
        if (!User::where('email', $email)->exists()) {
            throw new NotFoundException("Email does not exist.");
        }
    }
    public function changeRole(string $id, string $newRole): void
    {
        $user = User::find($id);
        if ($user) {
            $user->role = $newRole;
            $user->save();
        }
    }

    public function createTokenByEmail(string $email): string
    {
        $user = User::where('email', $email)->first();
        return $user->createToken('authToken', ["role-" . $user->role])
            ->plainTextToken;
    }
}
