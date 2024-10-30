<?php

namespace App\Domain\Invitations;

use App\Domain\Invitations\Entities\Invitation;
use App\Domain\Invitations\Entities\NewInvitation;

interface InvitationRepository
{
    public function create(NewInvitation $data);
    public function getById(string $id): Invitation;
    public function getAll();
    public function revoke(string $id);
    public function checkInvitationExists(string $id);
    public function setInvitationAccepted(string $id);
}
