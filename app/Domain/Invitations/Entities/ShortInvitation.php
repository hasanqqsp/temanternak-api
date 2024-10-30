<?php

namespace App\Domain\Invitations\Entities;

use App\Domain\Users\Entities\ShortUser;
use DateTime;

class ShortInvitation
{
    private string $id;
    private ShortUser $inviter;
    private string $message;
    private DateTime $createdAt;

    public function __construct(string $id, ShortUser $inviter, string $message, string $createdAt)
    {
        $this->id = $id;
        $this->inviter = $inviter;
        $this->message = $message;
        $this->createdAt = new DateTime($createdAt);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getInviter(): ShortUser
    {
        return $this->inviter;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt->format(DateTime::ATOM);
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function setInviter(ShortUser $inviter): void
    {
        $this->inviter = $inviter;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'inviter' => $this->inviter->toArray(),
            'message' => $this->message,
            'createdAt' => $this->getCreatedAt(),
        ];
    }
}
