<?php

namespace App\Domain\VeterinarianRegistrations\Entities;

use App\Domain\Invitations\Entities\Invitation;
use App\Domain\Invitations\Entities\ShortInvitation;
use App\Domain\Users\Entities\User;


class ShortVeterinarianRegistration
{
    private string $id;
    private string $status;
    private User $user;
    private string $whatsappNumber;
    private string $formalPictureFilePath;
    private string $createdAt;
    private string $updatedAt;
    private ShortInvitation $invitation;

    // Constructor
    public function __construct(
        string $id,
        string $status,
        User $user,
        string $whatsappNumber,
        string $formalPictureFilePath,
        string $createdAt,
        string $updatedAt,
        ShortInvitation $invitation
    ) {
        $this->id = $id;
        $this->status = $status;
        $this->user = $user;
        $this->whatsappNumber = $whatsappNumber;
        $this->formalPictureFilePath = $formalPictureFilePath;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->invitation = $invitation;
    }

    // Getters
    public function getId(): string
    {
        return $this->id;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getWhatsappNumber(): string
    {
        return $this->whatsappNumber;
    }

    public function getFormalPictureFilePath(): string
    {
        return $this->formalPictureFilePath;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    public function getInvitation(): ShortInvitation
    {
        return $this->invitation;
    }

    // Setters
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function setWhatsappNumber(string $whatsappNumber): void
    {
        $this->whatsappNumber = $whatsappNumber;
    }

    public function setFormalPictureFilePath(string $formalPictureFilePath): void
    {
        $this->formalPictureFilePath = $formalPictureFilePath;
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt(string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function setInvitation(Invitation $invitation): void
    {
        $this->invitation = $invitation;
    }

    // Convert to array
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'user' => $this->user->toArray(),
            'whatsappNumber' => $this->whatsappNumber,
            'formalPictureFilePath' => $this->formalPictureFilePath,
            'createdAt' => $this->getCreatedAt(),
            'updatedAt' => $this->updatedAt,
            'invitation' => $this->invitation->toArray(),
        ];
    }
}
