<?php

namespace App\Domain\Veterinarians\Entities;

class VeterinarianShort
{
    public $id;
    public $nameAndTitle;
    public $username;
    public $formalPicturePath;
    public $specializations;

    public function __construct($id, $nameAndTitle, $username, $formalPicturePath, $specializations)
    {
        $this->id = $id;
        $this->nameAndTitle = $nameAndTitle;
        $this->username = $username;
        $this->formalPicturePath = $formalPicturePath;
        $this->specializations = $specializations;
    }
}
