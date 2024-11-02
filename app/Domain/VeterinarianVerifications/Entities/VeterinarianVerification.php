<?php

namespace App\Domain\VeterinarianVerifications\Entities;

class VeterinarianVerification
{
    private string $status;
    private string $message;
    private string $createdAt;
    private string $updatedAt;
    private array $comments;

    public function __construct(
        string $status,
        string $message,
        string $createdAt,
        string $updatedAt,
        array $comments
    ) {
        $this->status = $status;
        $this->message = $message;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->comments = $comments;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    public function getComments(): array
    {
        return $this->comments;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt(string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function setComments(array $comments): void
    {
        $this->comments = $comments;
    }
}
