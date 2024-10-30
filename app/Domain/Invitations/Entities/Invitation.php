<?php

namespace App\Domain\Invitations\Entities;

use App\Domain\Users\Entities\User;
use DateTime;

class Invitation
{
    private string $id;
    private string $email;
    private string $name;
    private User $inviter;
    private ?string $message;
    private ?string $phone;
    private \DateTime $createdAt;
    private \DateTime $updatedAt;
    private ?bool $isRevoked;

    public function __construct(
        string $id,
        string $email,
        string $name,
        User $inviter,
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
        $this->createdAt = new \DateTime($createdAt);
        $this->updatedAt = new \DateTime($updatedAt);
        $this->isRevoked = $isRevoked;
    }

    public function getId(): int
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

    public function getInviter(): User
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
        return $this->createdAt->format(DateTime::ATOM);
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt->format(DateTime::ATOM);
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

    public function setInviter(User $inviter): void
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
        $this->createdAt = new \DateTime($createdAt);
    }

    public function setUpdatedAt(string $updatedAt): void
    {
        $this->updatedAt = new \DateTime($updatedAt);
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
            'createdAt' => $this->createdAt->format(DateTime::ATOM),
            'updatedAt' => $this->updatedAt->format(DateTime::ATOM),
            'isRevoked' => $this->isRevoked,
        ];
    }
}
