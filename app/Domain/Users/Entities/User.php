<?php

namespace App\Domain\Users\Entities;

class User
{
    private string $id;
    private string $name;
    private string $email;
    private string $createdAt;
    private string $updatedAt;
    private string $role;
    private ?string $phone;
    private string $username;
    private int $point = 0;
    private int $penaltyPoint = 0;
    private bool $isSuspended = false;

    public function __construct(
        string $id,
        string $name,
        string $email,
        string $createdAt,
        string $updatedAt,
        string $role,
        ?string $phone,
        string $username,
        ?int $penaltyPoint = null,
        bool $isSuspended = false
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
        return $this->createdAt;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPoint(): int
    {
        return $this->point;
    }

    public function getPenaltyPoint(): ?int
    {
        return $this->penaltyPoint;
    }

    public function getIsSuspended(): bool
    {
        return $this->isSuspended;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt(string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function setPoint(int $point): void
    {
        $this->point = $point;
    }

    public function setPenaltyPoint(?int $penaltyPoint): void
    {
        $this->penaltyPoint = $penaltyPoint;
    }

    public function setIsSuspended(bool $isSuspended = false): void
    {
        $this->isSuspended = $isSuspended;
    }

    public function toArray(): array
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
            'role' => $this->role,
            'phone' => $this->phone,
            'username' => $this->username,
        ];

        if ($this->role === 'basic') {
            $data['points'] = $this->point;
        }

        if ($this->role === 'veterinarian') {
            $data['penaltyPoint'] = $this->penaltyPoint;
            $data['isSuspended'] = $this->isSuspended;
        }

        return $data;
    }
}
