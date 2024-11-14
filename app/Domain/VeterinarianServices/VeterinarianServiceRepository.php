<?php

namespace App\Domain\VeterinarianServices;

use App\Domain\VeterinarianServices\Entities\EditService;
use App\Domain\VeterinarianServices\Entities\NewService;
use App\Domain\VeterinarianServices\Entities\VetService;

interface VeterinarianServiceRepository
{
    public function add(NewService $data): VetService;
    public function getById(string $id): VetService;
    public function checkIsApproved(string $id);
    public function checkIsSuspended(string $id);
    public function checkIfExist(string $id);
    public function approveService(string $id);
    public function suspendService(string $id);
    public function deleteService(string $id);
    public function unsuspendService(string $id);
    public function editWithoutApproval(EditService $data);
    public function editWithApproval(EditService $data);
    public function verifyOwnership(string $serviceId, string $veterinarianId);
    public function getPublicByVeterinarianId(string $veterinarianId);
    public function getAllByVeterinarianId(string $veterinarianId);
    public function getAllPublic();
    public function getAll();
    public function deleteById(string $id);
}
