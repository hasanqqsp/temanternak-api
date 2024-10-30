<?php

namespace App\Domain\VeterinarianRegistrations;

use App\Domain\VeterinarianRegistrations\Entities\AddedVeterinarianRegistration;
use App\Domain\VeterinarianRegistrations\Entities\NewVetRegistration;
use App\Domain\VeterinarianRegistrations\Entities\VeterinarianRegistration;

interface VeterinarianRegistrationRepository
{
    public function create(NewVetRegistration $userData): AddedVeterinarianRegistration;
    public function getById(string $id): VeterinarianRegistration;
    public function getByUserId(string $userId): array;
    public function getAll(): array;
    public function verifyNotExistsForInvitation(string $invitationId);
    public function verifyExistsForInvitation(string $invitationId);
    public function verifyNotAccepted(string $id);
    public function markRevisedBy(string $revisedId, string $revisingId);
    public function markReviewedBy(string $id, string $reviewerId);
    public function markRevising(string $revisingId, string $revisedId);
}
