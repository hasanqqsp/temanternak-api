<?php

namespace App\Domain\VeterinarianVerifications\Entities;

class EditVeterinarianVerification
{
    private string $registrationId;
    private string $status;
    private array $comments;
    private string $message;
    private string $verificatorId;

    public function __construct(string $registrationId, string $status, array $comments, string $message, string $verificatorId)
    {
        $this->registrationId = $registrationId;
        $this->status = $status;
        $this->comments = $comments;
        $this->message = $message;
        $this->verificatorId = $verificatorId;
    }

    public function getRegistrationId(): string
    {
        return $this->registrationId;
    }

    public function setRegistrationId(string $registrationId): void
    {
        $this->registrationId = $registrationId;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getComments(): array
    {
        return $this->comments;
    }

    public function setComments(array $comments): void
    {
        $this->comments = $comments;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function getVerificatorId(): string
    {
        return $this->verificatorId;
    }

    public function setVerificatorId(string $verificatorId): void
    {
        $this->verificatorId = $verificatorId;
    }

    public function toArray(): array
    {
        return [
            'registrationId' => $this->registrationId,
            'status' => $this->status,
            'comments' => $this->comments,
            'message' => $this->message,
            'verificatorId' => $this->verificatorId,
        ];
    }
}
