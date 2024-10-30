<?php

namespace App\Domain\VeterinarianRegistrations\Entities;

class AddedVeterinarianRegistration
{
    private string $id;
    private string $status;
    private string $userId;
    private string $invitationId;

    public function __construct(
        $id,
        $status,
        $userId,
        $invitationId
    ) {
        $this->id = $id;
        $this->status = $status;
        $this->userId = $userId;
        $this->invitationId = $invitationId;
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getInvitationId()
    {
        return $this->invitationId;
    }

    // toArray method
    public function toArray()
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'userId' => $this->userId,
            'invitationId' => $this->invitationId,
        ];
    }
}
