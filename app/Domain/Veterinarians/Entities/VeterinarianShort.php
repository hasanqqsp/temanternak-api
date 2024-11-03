<?php

namespace App\Domain\Veterinarians\Entities;

class VeterinarianShort
{
    private $id;
    private $nameAndTitle;
    private $username;
    private $formalPicturePath;
    private $specializations;

    public function __construct($id, $nameAndTitle, $username, $formalPicturePath, $specializations)
    {
        $this->id = $id;
        $this->nameAndTitle = $nameAndTitle;
        $this->username = $username;
        $this->formalPicturePath = $formalPicturePath;
        $this->specializations = $specializations;
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

    // Convert object to array
    public function toArray()
    {
        return [
            'id' => $this->id,
            'nameAndTitle' => $this->nameAndTitle,
            'username' => $this->username,
            'formalPicturePath' => $this->formalPicturePath,
            'specializations' => $this->specializations,
        ];
    }
}
