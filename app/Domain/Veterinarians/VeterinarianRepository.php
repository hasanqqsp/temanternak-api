<?php

namespace App\Domain\Veterinarians;

use App\Domain\Veterinarians\Entities\Veterinarian;

interface VeterinarianRepository
{
    public function getById(string $id): Veterinarian;
    public function getByUsername(string $username): Veterinarian;
    public function getAll(): array;
}
