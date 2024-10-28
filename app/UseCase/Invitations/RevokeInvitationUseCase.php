<?php

namespace App\UseCase\Invitations;

use App\Domain\Invitations\InvitationRepository;

class RevokeInvitationUseCase
{
    private $invitationRepository;

    public function __construct(InvitationRepository $invitationRepository)
    {
        $this->invitationRepository = $invitationRepository;
    }

    public function execute(string $invitationId)
    {
        $this->invitationRepository->checkInvitationExists($invitationId);
        return $this->invitationRepository->revoke($invitationId);
    }
}
