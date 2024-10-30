<?php

namespace App\Domain\Users\Entities;

class NewUser
{
    private string $name;
    private string $email;
    private string $password;
    private ?string $role;
    private string $phone;
    private string $username;
    private ?string $invitationId;

    public function __construct(string $name, string $email, string $hashedPassword, string $phone, string $username, ?string $invitationId = null, ?string $role = 'basic')
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $hashedPassword;
        $this->role = $role;
        $this->phone = $phone;
        $this->username = strtolower($username);
        $this->invitationId = $invitationId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getInvitationId(): ?string
    {
        return $this->invitationId;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function setInvitationId(?string $invitationId): void
    {
        $this->invitationId = $invitationId;
    }
}
