<?php

namespace App\Domain\Veterinarians\Entities;

class VeterinarianShortForList
{
    private $id;
    private $nameAndTitle;
    private $username;
    private $formalPicturePath;
    private $specializations;
    private $whatsappNumber;
    private $sipNumber;
    private $strvNumber;

    public function __construct($id, $nameAndTitle, $username, $formalPicturePath, $specializations, $whatsappNumber, $sipNumber, $strvNumber)
    {
        $this->id = $id;
        $this->nameAndTitle = $nameAndTitle;
        $this->username = $username;
        $this->formalPicturePath = $formalPicturePath;
        $this->specializations = $specializations;
        $this->whatsappNumber = $whatsappNumber;
        $this->sipNumber = $sipNumber;
        $this->strvNumber = $strvNumber;
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getNameAndTitle()
    {
        return $this->nameAndTitle;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getFormalPicturePath()
    {
        return $this->formalPicturePath;
    }

    public function getSpecializations()
    {
        return $this->specializations;
    }

    public function getWhatsappNumber()
    {
        return $this->whatsappNumber;
    }

    public function getSipNumber()
    {
        return $this->sipNumber;
    }

    public function getStrvNumber()
    {
        return $this->strvNumber;
    }

    // Setters
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setNameAndTitle($nameAndTitle)
    {
        $this->nameAndTitle = $nameAndTitle;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setFormalPicturePath($formalPicturePath)
    {
        $this->formalPicturePath = $formalPicturePath;
    }

    public function setSpecializations($specializations)
    {
        $this->specializations = $specializations;
    }

    public function setWhatsappNumber($whatsappNumber)
    {
        $this->whatsappNumber = $whatsappNumber;
    }

    public function setSipNumber($sipNumber)
    {
        $this->sipNumber = $sipNumber;
    }

    public function setStrvNumber($strvNumber)
    {
        $this->strvNumber = $strvNumber;
    }

    // Convert object to array
    public function toArray()
    {
        return [
            'id' => $this->id,
            'nameAndTitle' => $this->nameAndTitle,
            'username' => $this->username,
            'formalPicturePath' => $this->formalPicturePath,
            'specializations' => $this->specializations,
            'whatsappNumber' => $this->whatsappNumber,
            'sipNumber' => $this->sipNumber,
            'strvNumber' => $this->strvNumber,
        ];
    }
}
