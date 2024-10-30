<?php

namespace App\UseCase\VeterinarianRegistrations;


use App\Domain\VeterinarianRegistrations\Entities\AddedVeterinarianRegistration;
use App\Domain\VeterinarianRegistrations\Entities\NewVetRegistration;
use App\Domain\VeterinarianRegistrations\VeterinarianRegistrationRepository;

class CreateVeterinarianRegistrationUseCase
{
    private $veterinarianRegistrationRepository;

    public function __construct(VeterinarianRegistrationRepository $veterinarianRegistrationRepository)
    {
        $this->veterinarianRegistrationRepository = $veterinarianRegistrationRepository;
    }

    public function execute(NewVetRegistration $data): AddedVeterinarianRegistration
    {
        $this->veterinarianRegistrationRepository->verifyNotExistsForInvitation($data->getInvitationId());

        return $this->veterinarianRegistrationRepository->create($data);
    }
}
