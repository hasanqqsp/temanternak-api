<?php

namespace App\UseCase\VeterinarianRegistrations;

use App\Domain\VeterinarianRegistrations\VeterinarianRegistrationRepository;

class GetAllVeterinarianRegistrationsUseCase
{
    private $veterinarianRegistrationRepository;

    public function __construct(VeterinarianRegistrationRepository $veterinarianRegistrationRepository)
    {
        $this->veterinarianRegistrationRepository = $veterinarianRegistrationRepository;
    }

    public function execute()
    {
        return $this->veterinarianRegistrationRepository->getAll();
    }
}
