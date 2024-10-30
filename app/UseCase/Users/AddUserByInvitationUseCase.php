<?php

namespace App\UseCase\Users;

use App\Domain\Invitations\InvitationRepository;
use App\Domain\Users\Entities\AddedUser;
use App\Domain\Users\Entities\NewUser;
use App\Domain\Users\UserRepository;

class AddUserByInvitationUseCase
{
    protected $userRepository;
    protected $invitationRepository;

    public function __construct(UserRepository $userRepository, InvitationRepository $invitationRepository)
    {
        $this->userRepository = $userRepository;
        $this->invitationRepository = $invitationRepository;
    }

    public function execute(NewUser $userData): AddedUser
    {
        $this->invitationRepository->checkInvitationExists($userData->getInvitationId());
        $this->invitationRepository->setInvitationAccepted($userData->getInvitationId());
        $userData->setRole('invited-user');
        $this->userRepository->verifyEmailAvailable($userData->getEmail());
        $this->userRepository->verifyUsernameAvailable($userData->getUsername());
        return $this->userRepository->create($userData);
    }
}
