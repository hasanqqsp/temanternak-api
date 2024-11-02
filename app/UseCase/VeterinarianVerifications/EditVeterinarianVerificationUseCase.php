<?php

namespace App\UseCase\VeterinarianVerifications;

use App\Domain\Users\UserRepository;
use App\Domain\VeterinarianRegistrations\VeterinarianRegistrationRepository;
use App\Domain\VeterinarianVerifications\Entities\EditVeterinarianVerification;
use App\Domain\VeterinarianVerifications\VeterinarianVerificationRepository;

class EditVeterinarianVerificationUseCase
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

    public function execute(EditVeterinarianVerification $data,): void
    {
        $this->registrationRepository->checkIfExists($data->getRegistrationId());
        $this->registrationRepository->verifyNotRevised($data->getRegistrationId());
        if ($data->getStatus() == "ACCEPTED") {
            $registrationData = $this->registrationRepository->getById($data->getRegistrationId());
            $this->userRepository->changeRole($registrationData->getUser()->getId(), "veterinarian");
        }
        $this->repository->edit($data);
    }
}
