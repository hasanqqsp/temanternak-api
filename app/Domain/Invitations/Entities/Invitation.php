<?php

namespace App\Domain\Invitations\Entities;

use App\Domain\Users\Entities\ShortUser;

class Invitation
{
    private string $id;
    private string $email;
    private string $name;
    private ShortUser $inviter;
    private ?string $message;
    private ?string $phone;
    private string $createdAt;
    private string $updatedAt;
    private ?bool $isRevoked;

    public function __construct(
        string $id,
        string $email,
        string $name,
        ShortUser $inviter,
        ?string $message = null,
        ?string $phone = null,
        string $createdAt,
        string $updatedAt,
        ?bool $isRevoked = null
    ) {
        $this->id = $id;
        $this->email = $email;
        $this->name = $name;
        $this->inviter = $inviter;
        $this->message = $message;
        $this->phone = $phone;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->isRevoked = $isRevoked;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getInviter(): ShortUser
    {
        return $this->inviter;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    public function getIsRevoked(): ?bool
    {
        return $this->isRevoked;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setInviter(ShortUser $inviter): void
    {
        $this->inviter = $inviter;
    }

    public function setMessage(?string $message): void
    {
        $this->message = $message;
    }

    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt(string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function setIsRevoked(?bool $isRevoked): void
    {
        $this->isRevoked = $isRevoked;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'name' => $this->name,
            'inviter' => $this->inviter->toArray(),
            'message' => $this->message,
            'phone' => $this->phone,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
            'isRevoked' => $this->isRevoked,
        ];
    }
}
