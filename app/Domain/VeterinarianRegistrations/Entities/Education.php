<?php

namespace App\Domain\VeterinarianRegistrations\Entities;

class Education
{
    private string $institution;
    private int $year;
    private string $program;
    private string $title;

    public function __construct(string $institution, int $year, string $program, string $title)
    {
        $this->institution = $institution;
        $this->year = $year;
        $this->program = $program;
        $this->title = $title;
    }

    public function getInstitution(): string
    {
        return $this->institution;
    }

    public function getYear(): string
    {
        return $this->year;
    }

    public function getProgram(): string
    {
        return $this->program;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setInstitution(string $institution): void
    {
        $this->institution = $institution;
    }

    public function setYear(int $year): void
    {
        $this->year = $year;
    }

    public function setProgram(string $program): void
    {
        $this->program = $program;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function toArray(): array
    {
        return [
            'institution' => $this->institution,
            'year' => $this->year,
            'program' => $this->program,
            'title' => $this->title,
        ];
    }
}
