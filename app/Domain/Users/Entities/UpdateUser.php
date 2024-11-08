<?php

namespace App\Domain\Users\Entities;

class UpdateUser
{
    private string $id;
    private string $name;
    private string $email;
    private ?string $phone;
    private string $username;

    public function __construct(string $id, string $name, string $email, ?string $phone = null, string $username)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->username = strtolower($username);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }
}
