<?php

namespace App\Domain\VeterinarianServices\Entities;

class EditService
{
    private string $serviceId;
    private int $price;
    private int $duration;
    private string $description;
    private string $name;

    public function __construct(string $serviceId, int $price, int $duration, string $description, string $name)
    {
        $this->serviceId = $serviceId;
        $this->price = $price;
        $this->duration = $duration;
        $this->description = $description;
        $this->name = $name;
    }

    public function getServiceId(): string
    {
        return $this->serviceId;
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

    public function setServiceId(string $serviceId): void
    {
        $this->serviceId = $serviceId;
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
}
