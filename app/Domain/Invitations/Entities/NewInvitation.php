<?php

namespace App\Domain\Invitations\Entities;

class NewInvitation
{
    private $email;
    private $name;
    private $inviterId;
    private $message;
    private $phone;

    public function __construct($email, $name, $inviterId, $message = null, $phone = null)
    {
        $this->email = $email;
        $this->name = $name;
        $this->inviterId = $inviterId;
        $this->message = $message;
        $this->phone = $phone;
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
}
