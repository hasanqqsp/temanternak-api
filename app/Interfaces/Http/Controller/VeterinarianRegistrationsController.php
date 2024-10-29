<?php

namespace App\Interfaces\Http\Controller;

use App\Domain\Invitations\Entities\NewInvitation;
use App\Domain\Invitations\InvitationRepository;
use App\Domain\Users\VeterinarianRegistrationRepository;
use App\Domain\Users\VeterinarianRegistrationsRepository;
use App\Domain\VeterinarianRegistrations\Entities\GeneralIdentity;
use App\Domain\VeterinarianRegistrations\Entities\NewVetRegistration;
use App\UseCase\CreateVeterinarianRegistrationUseCase;
use App\UseCase\Invitations\CreateInvitationUseCase;
use App\UseCase\Invitations\GetAllInvitationUseCase;
use App\UseCase\Invitations\GetInvitationUseCase;
use App\UseCase\Invitations\RevokeInvitationUseCase;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class VeterinarianRegistrationController extends Controller
{
    private $createVeterinarianRegistrationUseCase;

    public function __construct(VeterinarianRegistrationRepository $veterinarianRegistrationRepository)
    {
        $this->createVeterinarianRegistrationUseCase = new CreateVeterinarianRegistrationUseCase($veterinarianRegistrationRepository);
    }

    public function create(Request $request)
    {
        $data = $request->all();
        $veterinarianRegistration = $this->createVeterinarianRegistrationUseCase->execute(
            new NewVetRegistration(
                new GeneralIdentity(
                    $data['generalIdentity']['frontTitle'],
                    $data['generalIdentity']['backTitle'],
                    $data['generalIdentity']['dateOfBirth'],
                    $data['generalIdentity']['whatsappNumber'],
                    $data['generalIdentity']['formalPictureId'],
                    $data['generalIdentity']['nik'],
                    $data['generalIdentity']['ktpFileId']
                ),
            )
        );
        return response()->json([
            "status" => "success",
            "data" => $veterinarianRegistration->toArray()
        ]);
    }
}
