<?php

namespace App\Domain\Invitations\Entities;

class Invitation
{
    private $id;
    private $email;
    private $name;
    private $inviterId;
    private $message;
    private $phone;
    private $createdAt;
    private $updatedAt;
    private $isRevoked;

    public function __construct($id, $email, $name, $inviterId, $message = null, $phone = null, $createdAt, $updatedAt, $isRevoked = null)
    {
        $this->id = $id;
        $this->email = $email;
        $this->name = $name;
        $this->inviterId = $inviterId;
        $this->message = $message;
        $this->phone = $phone;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->isRevoked = $isRevoked;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getInviterId()
    {
        return $this->inviterId;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function getIsRevoked()
    {
        return $this->isRevoked;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setInviterId($inviterId)
    {
        $this->inviterId = $inviterId;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    public function setIsRevoked($isRevoked)
    {
        $this->isRevoked = $isRevoked;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'name' => $this->name,
            'inviterId' => $this->inviterId,
            'message' => $this->message,
            'phone' => $this->phone,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
            'isRevoked' => $this->isRevoked,
        ];
    }
}
