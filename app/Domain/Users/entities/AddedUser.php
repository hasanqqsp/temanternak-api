<?php

namespace App\Domain\Users\Entities;

class AddedUser
{
    private string $id;
    private string $createdAt;

    public function __construct(string $id, string $createdAt)
    {
        $this->id = $id;
        $this->createdAt = $createdAt;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'createdAt' => $this->getCreatedAt(),
        ];
    }
}
