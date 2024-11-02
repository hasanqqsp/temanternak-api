<?php

namespace App\Interfaces\Http\Controller;


use App\Domain\VeterinarianRegistrations\Entities\BankAndTax;
use App\Domain\VeterinarianRegistrations\Entities\Education;
use App\Domain\VeterinarianRegistrations\Entities\GeneralIdentity;
use App\Domain\VeterinarianRegistrations\Entities\License;
use App\Domain\VeterinarianRegistrations\Entities\NewVetRegistration;
use App\Domain\VeterinarianRegistrations\Entities\OrganizationExperience;
use App\Domain\VeterinarianRegistrations\Entities\WorkingExperience;
use App\Domain\VeterinarianRegistrations\VeterinarianRegistrationRepository;
use App\UseCase\VeterinarianRegistrations\CreateVeterinarianRegistrationUseCase;
use App\UseCase\VeterinarianRegistrations\GetAllVeterinarianRegistrationsUseCase;
use App\UseCase\VeterinarianRegistrations\GetVeterinarianRegistrationByIdUseCase;
use App\UseCase\VeterinarianRegistrations\GetVeterinarianRegistrationByUserIdUseCase;
use App\UseCase\VeterinarianRegistrations\RevisingVeterinarianRegistrationUseCase;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class VeterinarianRegistrationsController extends Controller
{
    private $createVeterinarianRegistrationUseCase;
    private $getAllVeterinarianRegistrationsUseCase;
    private $getVeterinarianRegistrationByIdUseCase;
    private $revisingVeterinarianRegistrationUseCase;
    private $getVeterinarianRegistrationByUserIdUseCase;

    public function validate(Request $request)
    {
        return $request->validate([
            'generalIdentity.frontTitle' => 'required|string|max:255',
            'generalIdentity.backTitle' => 'required|string|max:255',
            'generalIdentity.dateOfBirth' => 'required|date',
            'generalIdentity.whatsappNumber' => 'required|string|max:15',
            'generalIdentity.formalPictureId' => 'required|string',
            'generalIdentity.nik' => 'required|string|max:16',
            'generalIdentity.ktpFileId' => 'required|string',
            'generalIdentity.biodata' => 'required|string',
            'license.strvFileId' => 'required|string',
            'license.strvValidUntil' => 'required|date',
            'license.strvNumber' => 'required|string|max:255',
            'license.sipFileId' => 'required|string',
            'license.sipValidUntil' => 'required|date',
            'license.sipNumber' => 'required|string|max:255',
            'specializations' => 'required|array',
            'educations' => 'required|array',
            'educations.*.institution' => 'required|string|max:255',
            'educations.*.year' => 'required|integer',
            'educations.*.program' => 'required|string|max:255',
            'educations.*.title' => 'required|string|max:255',
            'workingExperiences' => 'required|array',
            'workingExperiences.*.institution' => 'required|string|max:255',
            'workingExperiences.*.year' => 'required|integer',
            'workingExperiences.*.position' => 'required|string|max:255',
            'workingExperiences.*.isActive' => 'required|boolean',
            'organizationExperiences' => 'required|array',
            'organizationExperiences.*.institution' => 'required|string|max:255',
            'organizationExperiences.*.year' => 'required|integer',
            'organizationExperiences.*.position' => 'required|string|max:255',
            'organizationExperiences.*.isActive' => 'required|boolean',
            'bankAndTax.npwp' => 'required|string|max:15',
            'bankAndTax.npwpFileId' => 'required|string',
            'bankAndTax.bankName' => 'required|string|max:255',
            'bankAndTax.bankAccountNumber' => 'required|string|max:255',
            'bankAndTax.bankAccountName' => 'required|string|max:255',
            'bankAndTax.bankAccountFileId' => 'required|string',
            'invitationId' => 'required|string',
            'biodata' => 'string'
        ]);
    }

    public function createRegistrationData($validatedData, $userId)
    {
        $educations = array_map(function ($education) {
            return new Education(
                $education['institution'],
                $education['year'],
                $education['program'],
                $education['title']
            );
        }, $validatedData['educations']);

        $workingExperiences = array_map(function ($workingExperience) {
            return new WorkingExperience(
                $workingExperience['institution'],
                $workingExperience['year'],
                $workingExperience['position'],
                $workingExperience['isActive']
            );
        }, $validatedData['workingExperiences']);

        $organizationExperiences = array_map(function ($organizationExperience) {
            return new OrganizationExperience(
                $organizationExperience['institution'],
                $organizationExperience['year'],
                $organizationExperience['position'],
                $organizationExperience['isActive']
            );
        }, $validatedData['organizationExperiences']);
        return new NewVetRegistration(
            new GeneralIdentity(
                $validatedData['generalIdentity']['frontTitle'],
                $validatedData['generalIdentity']['backTitle'],
                $validatedData['generalIdentity']['dateOfBirth'],
                $validatedData['generalIdentity']['whatsappNumber'],
                $validatedData['generalIdentity']['formalPictureId'],
                $validatedData['generalIdentity']['nik'],
                $validatedData['generalIdentity']['ktpFileId'],
                $validatedData['generalIdentity']['biodata']
            ),
            new License(
                $validatedData['license']['strvFileId'],
                $validatedData['license']['strvValidUntil'],
                $validatedData['license']['strvNumber'],
                $validatedData['license']['sipFileId'],
                $validatedData['license']['sipValidUntil'],
                $validatedData['license']['sipNumber']
            ),
            $validatedData['specializations'],
            $educations,
            $workingExperiences,
            $organizationExperiences,
            new BankAndTax(
                $validatedData['bankAndTax']['npwp'],
                $validatedData['bankAndTax']['npwpFileId'],
                $validatedData['bankAndTax']['bankName'],
                $validatedData['bankAndTax']['bankAccountNumber'],
                $validatedData['bankAndTax']['bankAccountFileId'],
                $validatedData['bankAndTax']['bankAccountName'],
            ),
            $validatedData['invitationId'],
            $userId
        );
    }

    public function __construct(VeterinarianRegistrationRepository $veterinarianRegistrationRepository)
    {
        $this->createVeterinarianRegistrationUseCase = new CreateVeterinarianRegistrationUseCase($veterinarianRegistrationRepository);
        $this->getAllVeterinarianRegistrationsUseCase = new GetAllVeterinarianRegistrationsUseCase($veterinarianRegistrationRepository);
        $this->getVeterinarianRegistrationByIdUseCase = new GetVeterinarianRegistrationByIdUseCase($veterinarianRegistrationRepository);
        $this->revisingVeterinarianRegistrationUseCase = new RevisingVeterinarianRegistrationUseCase($veterinarianRegistrationRepository);
        $this->getVeterinarianRegistrationByUserIdUseCase = new GetVeterinarianRegistrationByUserIdUseCase($veterinarianRegistrationRepository);
    }

    public function create(Request $request)
    {
        $validatedData = $this->validate($request);
        $veterinarianRegistration = $this->createVeterinarianRegistrationUseCase->execute(
            $this->createRegistrationData(
                $validatedData,
                $request->user()->id
            )
        );
        return response()->json([
            "status" => "success",
            "data" => $veterinarianRegistration->toArray()
        ]);
    }

    public function getAll()
    {
        $veterinarianRegistrations = $this->getAllVeterinarianRegistrationsUseCase->execute();
        return response()->json([
            "status" => "success",
            "data" => $veterinarianRegistrations
        ]);
    }

    public function getById($registrationId)
    {
        $veterinarianRegistration = $this->getVeterinarianRegistrationByIdUseCase->execute($registrationId);
        return response()->json([
            "status" => "success",
            "data" => $veterinarianRegistration->toArray()
        ]);
    }

    public function getMy(Request $request)
    {
        $veterinarianRegistrations = $this->getVeterinarianRegistrationByUserIdUseCase->execute($request->user()->id);
        return response()->json([
            "status" => "success",
            "data" => $veterinarianRegistrations
        ]);
    }
    public function getByUserId($userId)
    {
        $veterinarianRegistrations = $this->getVeterinarianRegistrationByUserIdUseCase->execute($userId);
        return response()->json([
            "status" => "success",
            "data" => $veterinarianRegistrations
        ]);
    }

    public function revise(Request $request)
    {
        $validatedData = $this->validate($request);
        $veterinarianRegistration = $this->revisingVeterinarianRegistrationUseCase->execute(
            $this->createRegistrationData(
                $validatedData,
                $request->user()->id
            )
        );
        return response()->json([
            "status" => "success",
            "data" => $veterinarianRegistration->toArray()
        ]);
    }
}
