<?php

namespace App\Interfaces\Http\Controller;

use App\Domain\Invitations\Entities\NewInvitation;
use App\Domain\Invitations\InvitationRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class InvitationsController extends Controller
{
    private $invitationRepository;
    public function __construct(InvitationRepository $invitationRepository)
    {
        $this->invitationRepository = $invitationRepository;
    }

    // Get a single invitation by ID
    public function get($id)
    {
        $invitation = $this->invitationRepository->getById($id);
        return response()->json([
            "status" => "success",
            "data" => $invitation->toArray()
        ]);
    }

    // Get all invitations
    public function getAll()
    {
        $invitations =  $this->invitationRepository->getAll();
        return response()->json([
            "status" => "success",
            "data" => $invitations
        ]);
    }

    // Revoke an invitation by ID
    public function revoke($id)
    {
        $invitations =  $this->invitationRepository->revoke($id);

        return response()->json([
            "status" => "success",
            'message' => 'Invitation revoked successfully'
        ]);
    }

    // Create a new invitation
    public function create(Request $request)
    {

        $invitation = $this->invitationRepository->create(new NewInvitation(
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
