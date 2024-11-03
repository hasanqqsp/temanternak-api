<?php

namespace App\UseCase\VeterinarianServices;

use App\Domain\VeterinarianServices\Entities\EditService;
use App\Domain\VeterinarianServices\VeterinarianServiceRepository;

class EditVeterinarianServiceUseCase
{
    private $repository;

    public function __construct(VeterinarianServiceRepository $repository)
    {
        $this->repository = $repository;
    }
    public function execute(EditService $data, $credentialsId)
    {
        $this->repository->verifyOwnership($data->getServiceId(), $credentialsId);
        $oldData = $this->repository->getById($data->getServiceId());
        if ($data->getPrice() !== $oldData->getPrice() || $data->getDuration() !== $oldData->getDuration()) {
            return $this->repository->editWithApproval($data);
        }
        return $this->repository->editWithoutApproval($data);
    }
}
