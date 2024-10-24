<?php

namespace App\Domain\Users\Entities;

class User
{
    public string $id;
    public string $name;
    public string $email;
    public string $createdAt;
    public string $updatedAt;

    public function __construct(
        string $id,
        string $name,
        string $email,
        string $createdAt,
        string $updatedAt,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getId(): int
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
}
