<?php

namespace App\UseCase\VeterinarianRegistrations;

use App\Domain\VeterinarianRegistrations\VeterinarianRegistrationRepository;

class GetVeterinarianRegistrationByUserIdUseCase
{
    private $veterinarianRegistrationRepository;

    public function __construct(VeterinarianRegistrationRepository $veterinarianRegistrationRepository)
    {
        $this->veterinarianRegistrationRepository = $veterinarianRegistrationRepository;
    }

    public function execute(string $userId)
    {
        return $this->veterinarianRegistrationRepository->getByUserId($userId);
    }
}
