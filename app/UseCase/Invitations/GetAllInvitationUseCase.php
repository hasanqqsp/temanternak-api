<?php

namespace App\UseCase\Invitations;

use App\Domain\Invitations\InvitationRepository;

class GetAllInvitationUseCase
{
    private $invitationRepository;

    public function __construct(InvitationRepository $invitationRepository)
    {
        $this->invitationRepository = $invitationRepository;
    }

    public function execute()
    {
        return $this->invitationRepository->getAll();
    }
}
