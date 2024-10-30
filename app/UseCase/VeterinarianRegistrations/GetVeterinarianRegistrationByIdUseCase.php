<?php

namespace App\UseCase\VeterinarianRegistrations;

use App\Domain\VeterinarianRegistrations\VeterinarianRegistrationRepository;

class GetVeterinarianRegistrationByIdUseCase
{
    private $veterinarianRegistrationRepository;

    public function __construct(VeterinarianRegistrationRepository $veterinarianRegistrationRepository)
    {
        $this->veterinarianRegistrationRepository = $veterinarianRegistrationRepository;
    }

    public function execute(string $id)
    {
        return $this->veterinarianRegistrationRepository->getById($id);
    }
}
