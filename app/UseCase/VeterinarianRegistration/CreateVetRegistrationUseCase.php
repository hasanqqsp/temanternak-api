<?php

namespace App\UseCase;

use App\Domain\Users\VeterinarianRegistrationRepository;
use App\Domain\Users\VeterinarianRegistrationsRepository;
use App\Domain\VeterinarianRegistrations\Entities\AddedVeterinarianRegistration;
use App\Domain\VeterinarianRegistrations\Entities\NewVetRegistration;

class CreateVeterinarianRegistrationUseCase
{
    private $veterinarianRepository;

    public function __construct(VeterinarianRegistrationRepository $veterinarianRepository)
    {
        $this->veterinarianRepository = $veterinarianRepository;
    }

    public function execute(NewVetRegistration $data): AddedVeterinarianRegistration
    {
        return $this->veterinarianRepository->create($data);
    }
}
