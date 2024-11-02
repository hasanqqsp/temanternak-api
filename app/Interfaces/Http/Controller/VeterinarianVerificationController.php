<?php

namespace App\Interfaces\Http\Controller;

use App\Domain\Users\UserRepository;
use App\Domain\VeterinarianRegistrations\VeterinarianRegistrationRepository;
use App\Domain\VeterinarianVerifications\Entities\EditVeterinarianVerification;
use App\Domain\VeterinarianVerifications\Entities\NewVeterinarianVerification;
use App\Domain\VeterinarianVerifications\VeterinarianVerificationRepository;
use App\UseCase\VeterinarianVerifications\AddVeterinarianVerificationUseCase;
use App\UseCase\VeterinarianVerifications\EditVeterinarianVerificationUseCase;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class VeterinarianVerificationController extends Controller
{
    private $addVeterinarianVerificationUseCase;
    private $editVeterinarianVerificationUseCase;
    public function __construct(VeterinarianVerificationRepository $repository, VeterinarianRegistrationRepository $registrationRepository, UserRepository $userRepository)
    {
        $this->addVeterinarianVerificationUseCase = new AddVeterinarianVerificationUseCase($repository, $registrationRepository, $userRepository);
        $this->editVeterinarianVerificationUseCase = new EditVeterinarianVerificationUseCase($repository, $registrationRepository, $userRepository);
    }
    public function add(Request $request, $registrationId)
    {
        $validatedData = $request->validate([
            'status' => 'required|string',
            'comments' => 'nullable|array',
            'message' => 'required|string',
        ]);

        $verification = $this->addVeterinarianVerificationUseCase->execute(
            new NewVeterinarianVerification(
                $registrationId,
                $validatedData['status'],
                $validatedData['comments'],
                $validatedData['message'],
                $request->user()->id
            )
        );

        return response()->json(
            [
                "status" => "success",
                "message" => "Verification successfully added",
                "data" => $verification->toArray()
            ]
        );
    }

    public function edit(Request $request, $registrationId)
    {
        $validatedData = $request->validate([
            'status' => 'required|string',
            'comments' => 'nullable|array',
            'message' => 'required|string',
        ]);

        $this->editVeterinarianVerificationUseCase->execute(
            new EditVeterinarianVerification(
                $registrationId,
                $validatedData['status'],
                $validatedData['comments'],
                $validatedData['message'],
                $request->user()->id
            )
        );

        return response()->json(
            [
                "status" => "success",
                "message" => "Verification successfully edited"
            ]
        );
    }
}
