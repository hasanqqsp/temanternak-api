<?php

namespace App\Domain\Users\Entities;

use DateTime;

class AddedUser
{
    private string $id;
    private \DateTime $createdAt;

    public function __construct(string $id, \DateTime $createdAt)
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
        return $this->createdAt->format(DateTime::ATOM);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'createdAt' => $this->getCreatedAt(),
        ];
    }
}
