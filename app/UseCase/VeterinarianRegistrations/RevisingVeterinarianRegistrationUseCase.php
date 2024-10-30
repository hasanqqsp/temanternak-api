<?php

namespace App\UseCase\VeterinarianRegistrations;

use App\Commons\Exceptions\ClientException;
use App\Domain\VeterinarianRegistrations\Entities\NewVetRegistration;
use App\Domain\VeterinarianRegistrations\VeterinarianRegistrationRepository;

class RevisingVeterinarianRegistrationUseCase
{
    private $veterinarianRegistrationRepository;

    public function __construct(VeterinarianRegistrationRepository $veterinarianRegistrationRepository)
    {
        $this->veterinarianRegistrationRepository = $veterinarianRegistrationRepository;
    }

    public function execute(NewVetRegistration $data)
    {
        $this->veterinarianRegistrationRepository->verifyExistsForInvitation($data->getInvitationId());

        $lastRegistration = $this->veterinarianRegistrationRepository->getByUserId($data->getUserId())[0];
        if ($lastRegistration["invitation"]["id"] !== $data->getInvitationId()) {
            throw new ClientException('The invitation ID of the last registration does not match the new registration.');
        }
        if ($lastRegistration["user"]["id"] !== $data->getUserId()) {
            throw new ClientException('The user ID of the last registration does not match the new registration.');
        }
        $this->veterinarianRegistrationRepository->verifyNotAccepted($lastRegistration["id"]);
        $registration = $this->veterinarianRegistrationRepository->create($data);

        $this->veterinarianRegistrationRepository->markRevising($registration->getId(), $lastRegistration["id"]);
        $this->veterinarianRegistrationRepository->markRevisedBy($lastRegistration["id"], $registration->getId());
        // Fetch the existing registration
        return $registration;
    }
}
