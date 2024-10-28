<?php

namespace App\UseCase\Invitations;

use App\Domain\Invitations\Entities\NewInvitation;
use App\Domain\Invitations\InvitationRepository;

class CreateInvitationUseCase
{
    private $invitationRepository;

    public function __construct(InvitationRepository $invitationRepository)
    {
        $this->invitationRepository = $invitationRepository;
    }

    public function execute(NewInvitation $data)
    {
        // Create invitation
        $invitation = $this->invitationRepository->create($data);

        // Send invitation email
        // $this->sendInvitationEmail($invitation);

        return $invitation;
    }
}
