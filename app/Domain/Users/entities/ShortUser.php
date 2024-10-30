<?php

namespace App\Domain\Users\Entities;

class ShortUser
{
    private string $id;
    private string $name;
    private string $role;

    // Constructor
    public function __construct(string $id, string $name, string $role)
    {
        $this->id = $id;
        $this->name = $name;
        $this->role = $role;
    }

    // Getters
    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    // Setters
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    // Convert object to array
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'role' => $this->role,
        ];
    }
}
