<?php

namespace App\Domain\Invitations\Entities;

class AddedInvitation
{
    private $id;
    private $email;
    private $name;
    private $phone;
    private $createdAt;

    public function __construct($id, $email, $name, $phone, $createdAt)
    {
        $this->id = $id;
        $this->email = $email;
        $this->name = $name;
        $this->phone = $phone;
        $this->createdAt = $createdAt;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'name' => $this->name,
            'phone' => $this->phone,
            'createdAt' => $this->createdAt,
        ];
    }
}
