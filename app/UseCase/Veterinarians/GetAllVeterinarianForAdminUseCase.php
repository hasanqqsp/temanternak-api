<?php

namespace App\UseCase\Veterinarians;

use App\Domain\Veterinarians\VeterinarianRepository;

class GetAllVeterinarianForAdminUseCase
{
    protected $veterinarianRepository;

    public function __construct(VeterinarianRepository $veterinarianRepository)
    {
        $this->veterinarianRepository = $veterinarianRepository;
    }

    public function execute()
    {
        return $this->veterinarianRepository->getAllForAdmin();
    }
}
