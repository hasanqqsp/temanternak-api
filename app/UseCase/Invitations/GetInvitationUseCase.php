<?php

namespace App\UseCase\Invitations;

use App\Domain\Invitations\InvitationRepository;

class GetInvitationUseCase
{
    private $invitationRepository;

    public function __construct(InvitationRepository $invitationRepository)
    {
        $this->invitationRepository = $invitationRepository;
    }

    public function execute($invitationId)
    {
        $this->invitationRepository->checkInvitationExists($invitationId);
        return $this->invitationRepository->getById($invitationId);
    }
}
