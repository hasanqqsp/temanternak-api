<?php

namespace App\Infrastructure\Repository\Eloquent;

use App\Commons\Exceptions\NotFoundException;
use App\Domain\Invitations\Entities\AddedInvitation;
use App\Domain\Invitations\Entities\Invitation;
use App\Domain\Invitations\Entities\NewInvitation;
use App\Domain\Invitations\InvitationRepository;
use App\Domain\Users\Entities\ShortUser;
use App\Infrastructure\Repository\Models\Invitation as EloquentInvitation;

class InvitationRepositoryEloquent implements InvitationRepository
{
    public function setInvitationAccepted($invitationId)
    {
        $invitation = EloquentInvitation::find($invitationId);
        if ($invitation) {
            $invitation->is_accepted = true;
            $invitation->save();
        }

        return $invitation;
    }

    public function create(NewInvitation $invitationData)
    {
        $invitation = new EloquentInvitation();
        $invitation->email = $invitationData->getEmail();
        $invitation->name = $invitationData->getName();
        $invitation->inviter_id = $invitationData->getInviterId();
        $invitation->message = $invitationData->getMessage();
        $invitation->phone = $invitationData->getPhone();
        $invitation->is_revoked = false;
        $invitation->save();

        return new AddedInvitation(
            $invitation->id,
            $invitation->email,
            $invitation->name,
            $invitation->phone,
            $invitation->created_at
        );
    }

    public function getById($invitationId): Invitation
    {
        $invitation = EloquentInvitation::find($invitationId);

        return new Invitation(
            $invitation->id,
            $invitation->email,
            $invitation->name,
            new ShortUser(
                $invitation->inviter->id,
                $invitation->inviter->user,
                $invitation->inviter->id,
            ),
            $invitation->message,
            $invitation->phone,
            $invitation->created_at,
            $invitation->updated_at,
            $invitation->is_revoked,
            $invitation->is_accepted
        );
    }

    public function getAll()
    {
        $invitations = EloquentInvitation::all();

        return $invitations->map(function ($invitation) {
            return (new Invitation(
                $invitation->id,
                $invitation->email,
                $invitation->name,
                new ShortUser(
                    $invitation->inviter_id,
                    $invitation->inviter->name,
                    $invitation->inviter->role,
                ),
                $invitation->message,
                $invitation->phone,
                $invitation->created_at,
                $invitation->updated_at,
                $invitation->is_revoked
            ))->toArray();
        })->toArray();
    }

    public function revoke($invitationId)
    {
        $invitation = EloquentInvitation::find($invitationId);
        if ($invitation) {
            $invitation->is_revoked = true;
            $invitation->save();
        }

        return $invitation;
    }
    public function checkInvitationExists(string $id)
    {
        $exists = EloquentInvitation::where('id', $id)->exists();
        if (!$exists) {
            throw new NotFoundException("Invitation with id {$id} does not exist.");
        }
    }
}
