<?php

namespace App\Domain\VeterinarianServices\Entities;

class NewService
{
    private string $veterinarianId;
    private int $price;
    private int $duration;
    private string $description;
    private string $name;

    public function __construct(string $veterinarianId, int $price, int $duration, string $description, string $name)
    {
        $this->veterinarianId = $veterinarianId;
        $this->price = $price;
        $this->duration = $duration;
        $this->description = $description;
        $this->name = $name;
    }

    public function getVeterinarianId(): string
    {
        return $this->veterinarianId;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
