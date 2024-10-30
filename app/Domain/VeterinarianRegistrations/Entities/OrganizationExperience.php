<?php

namespace App\Domain\VeterinarianRegistrations\Entities;

class OrganizationExperience
{
    private $institution;
    private $year;
    private $position;
    private $isActive;

    public function __construct($institution, $year, $position, $isActive)
    {
        $this->institution = $institution;
        $this->year = $year;
        $this->position = $position;
        $this->isActive = $isActive;
    }

    public function getInstitution()
    {
        return $this->institution;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function getIsActive()
    {
        return $this->isActive;
    }

    public function toArray()
    {
        return [
            'institution' => $this->institution,
            'year' => $this->year,
            'position' => $this->position,
            'isActive' => $this->isActive,
        ];
    }
}
