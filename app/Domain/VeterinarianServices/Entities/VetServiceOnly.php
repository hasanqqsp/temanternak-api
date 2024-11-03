<?php

namespace App\Domain\VeterinarianServices\Entities;

class VetServiceOnly
{
    private string $id;
    private int $price;
    private int $duration;
    private string $description;
    private string $name;

    // Constructor
    public function __construct(
        string $id,
        int $price,
        int $duration,
        string $description,
        string $name
    ) {
        $this->id = $id;
        $this->price = $price;
        $this->duration = $duration;
        $this->description = $description;
        $this->name = $name;
    }

    // Getters
    public function getId(): string
    {
        return $this->id;
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
            'price' => $this->price,
            'duration' => $this->duration,
            'description' => $this->description,
            'name' => $this->name,
        ];
    }
}
