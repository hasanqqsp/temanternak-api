<?php

namespace App\Domain\Users\Entities;

class User
{
    public string $id;
    public string $name;
    public string $email;
    public string $createdAt;
    public string $updatedAt;
    public string $role;
    public string $phone;
    public string $username;

    public function __construct(
        string $id,
        string $name,
        string $email,
        string $createdAt,
        string $updatedAt,
        string $role,
        string $phone,
        string $username
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->role = $role;
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

    public function getCreatedAt(): string
    {
        return (new \DateTime($this->createdAt))->format(\DateTime::ATOM);
    }

    public function getUpdatedAt(): string
    {
        return (new \DateTime($this->updatedAt))->format(\DateTime::ATOM);
    }

    public function getRole(): string
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

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
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

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'createdAt' => $this->getCreatedAt(),
            'updatedAt' => $this->getUpdatedAt(),
            'role' => $this->role,
            'phone' => $this->phone,
            'username' => $this->username,
        ];
    }
}
