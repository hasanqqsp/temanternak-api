<?php

namespace App\Interfaces\Http\Controller;

use App\Domain\Invitations\Entities\NewInvitation;
use App\Domain\Invitations\InvitationRepository;
use App\UseCase\Invitations\CreateInvitationUseCase;
use App\UseCase\Invitations\GetAllInvitationUseCase;
use App\UseCase\Invitations\GetInvitationUseCase;
use App\UseCase\Invitations\RevokeInvitationUseCase;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class InvitationsController extends Controller
{
    private $createInvitationUseCase;
    private $getAllInvitationsUseCase;
    private $getInvitationUseCase;
    private $revokeInvitationUseCase;

    public function __construct(InvitationRepository $invitationRepository)
    {
        $this->createInvitationUseCase = new CreateInvitationUseCase($invitationRepository);
        $this->getAllInvitationsUseCase = new GetAllInvitationUseCase($invitationRepository);
        $this->getInvitationUseCase = new GetInvitationUseCase($invitationRepository);
        $this->revokeInvitationUseCase = new RevokeInvitationUseCase($invitationRepository);
    }

    // Get a single invitation by ID
    public function get($id)
    {
        $invitation = $this->getInvitationUseCase->execute($id);
        return response()->json([
            "status" => "success",
            "data" => $invitation->toArray()
        ]);
    }

    // Get all invitations
    public function getAll()
    {
        $invitations =  $this->getAllInvitationsUseCase->execute();
        return response()->json([
            "status" => "success",
            "data" => $invitations
        ]);
    }

    // Revoke an invitation by ID
    public function revoke($id)
    {
        $this->revokeInvitationUseCase->execute($id);

        return response()->json([
            "status" => "success",
            'message' => 'Invitation revoked successfully'
        ]);
    }

    // Create a new invitation
    public function create(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string|max:255',
            'message' => 'nullable|string',
            'phone' => 'nullable|string|max:15'
        ]);

        $invitation = $this->createInvitationUseCase->execute(new NewInvitation(
            $request->email,
            $request->name,
            $request->user()->id,
            $request->message,
            $request->phone
        ));
        return response()->json([
            "status" => "success",
            'message' => 'Invitation created successfully',
            "data" => $invitation->toArray()
        ], 201);
    }
}
