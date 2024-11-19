<?php

namespace App\Domain\VeterinarianServices\Entities;

use App\Domain\Veterinarians\Entities\VeterinarianShort;

class VetServiceForAdmin
{
    private string $id;
    private VeterinarianShort $veterinarian;
    private int $price;
    private int $duration;
    private string $description;
    private string $name;
    private bool $isAccepted;
    private bool $isSuspended;
    private bool $isDeleted; // Added attribute

    // Constructor
    public function __construct(
        string $id,
        VeterinarianShort $veterinarian,
        int $price,
        int $duration,
        string $description,
        string $name,
        bool $isAccepted,
        bool $isSuspended,
        bool $isDeleted // Added parameter
    ) {
        $this->id = $id;
        $this->veterinarian = $veterinarian;
        $this->price = $price;
        $this->duration = $duration;
        $this->description = $description;
        $this->name = $name;
        $this->isAccepted = $isAccepted;
        $this->isSuspended = $isSuspended;
        $this->isDeleted = $isDeleted; // Set attribute
    }

    // Getters
    public function getId(): string
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

    public function getIsAccepted(): bool
    {
        return $this->isAccepted;
    }

    public function getIsSuspended(): bool
    {
        return $this->isSuspended;
    }

    public function getIsDeleted(): bool // Added getter
    {
        return $this->isDeleted;
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

    public function setIsAccepted(bool $isAccepted): void
    {
        $this->isAccepted = $isAccepted;
    }

    public function setIsSuspended(bool $isSuspended): void
    {
        $this->isSuspended = $isSuspended;
    }

    public function setIsDeleted(bool $isDeleted): void // Added setter
    {
        $this->isDeleted = $isDeleted;
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
            'isAccepted' => $this->isAccepted,
            'isSuspended' => $this->isSuspended,
            'isDeleted' => $this->isDeleted, // Added to array
        ];
    }
}
