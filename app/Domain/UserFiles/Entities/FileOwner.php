<?php

namespace App\Domain\UserFiles\Entities;

class FileOwner
{
    private string $id;
    private string $username;
    private string $name;

    public function __construct(string $id, string $username, string $name)
    {
        $this->id = $id;
        $this->username = $username;
        $this->name = $name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getName(): string
    {
        return $this->name;
    }
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'name' => $this->name,
        ];
    }
}
