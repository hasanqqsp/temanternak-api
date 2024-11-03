<?php

namespace App\Domain\VeterinarianServices\Entities;

use App\Domain\Veterinarians\Entities\VeterinarianShort;

class VetService
{
    private string $id;
    private VeterinarianShort $veterinarian;
    private int $price;
    private int $duration;
    private string $description;
    private string $name;

    // Constructor
    public function __construct(
        string $id,
        VeterinarianShort $veterinarian,
        int $price,
        int $duration,
        string $description,
        string $name
    ) {
        $this->id = $id;
        $this->veterinarian = $veterinarian;
        $this->price = $price;
        $this->duration = $duration;
        $this->description = $description;
        $this->name = $name;
    }

    // Getters
    public function getId(): int
    {
        return $this->id;
    }

    public function getVeterinarian(): VeterinarianShort
    {
        return $this->veterinarian;
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

    // Setters
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function setVeterinarian(VeterinarianShort $veterinarian): void
    {
        $this->veterinarian = $veterinarian;
    }

    public function setPrice(int $price): void
    {
        $this->price = $price;
    }

    public function setDuration(int $duration): void
    {
        $this->duration = $duration;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    // Convert object to array
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'veterinarian' => $this->veterinarian->toArray(),
            'price' => $this->price,
            'duration' => $this->duration,
            'description' => $this->description,
            'name' => $this->name,
        ];
    }
}
