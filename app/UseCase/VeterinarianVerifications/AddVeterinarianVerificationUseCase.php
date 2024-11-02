<?php

namespace App\UseCase\VeterinarianVerifications;

use App\Domain\Users\UserRepository;
use App\Domain\VeterinarianRegistrations\VeterinarianRegistrationRepository;
use App\Domain\VeterinarianVerifications\Entities\AddedVeterinarianVerification;
use App\Domain\VeterinarianVerifications\Entities\NewVeterinarianVerification;
use App\Domain\VeterinarianVerifications\VeterinarianVerificationRepository;

class AddVeterinarianVerificationUseCase
{
    protected $repository;
    protected $registrationRepository;
    protected $userRepository;

    public function __construct(VeterinarianVerificationRepository $repository, VeterinarianRegistrationRepository $registrationRepository, UserRepository $userRepository)
    {
        $this->repository = $repository;
        $this->registrationRepository = $registrationRepository;
        $this->userRepository =  $userRepository;
    }

    public function execute(NewVeterinarianVerification $data): AddedVeterinarianVerification
    {
        $this->registrationRepository->verifyIsPending($data->getRegistrationId());

        if ($data->getStatus() == "ACCEPTED") {
            $registrationData = $this->registrationRepository->getById($data->getRegistrationId());
            $this->userRepository->changeRole($registrationData->getUser()->getId(), "veterinarian");
        }

        return $this->repository->add($data);
    }
}
