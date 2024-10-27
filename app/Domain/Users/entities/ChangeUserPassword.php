<?php

namespace App\Domain\Users\Entities;

class ChangeUserPassword
{
    private string $userId;
    private string $oldPassword;
    private string $newPassword;

    public function __construct(string $userId, string $oldPassword, string $newPassword)
    {
        $this->userId = $userId;
        $this->oldPassword = $oldPassword;
        $this->newPassword = $newPassword;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getOldPassword(): string
    {
        return $this->oldPassword;
    }

    public function getNewPassword(): string
    {
        return $this->newPassword;
    }

    public function setNewPassword(string $newPassword): void
    {
        $this->newPassword = $newPassword;
    }
}
