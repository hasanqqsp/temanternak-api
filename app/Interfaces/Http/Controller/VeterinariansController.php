<?php

namespace App\Interfaces\Http\Controller;

use App\Domain\Users\UserRepository;
use App\Domain\VeterinarianRegistrations\Entities\BankAndTax;
use App\Domain\VeterinarianRegistrations\Entities\Education;
use App\Domain\VeterinarianRegistrations\Entities\GeneralIdentity;
use App\Domain\VeterinarianRegistrations\Entities\License;
use App\Domain\VeterinarianRegistrations\Entities\OrganizationExperience;
use App\Domain\VeterinarianRegistrations\Entities\WorkingExperience;
use App\Domain\Veterinarians\VeterinarianRepository;
use App\Domain\VeterinarianSchedules\VeterinarianScheduleRepository;
use App\Domain\Wallets\WalletLogRepository;
use App\UseCase\Veterinarians\GetAllVeterinarianUseCase;
use App\UseCase\Veterinarians\GetBankAndTaxForUpdateUseCase;
use App\UseCase\Veterinarians\GetEducationsForUpdateUseCase;
use App\UseCase\Veterinarians\GetGeneralIdentityForUpdateUseCase;
use App\UseCase\Veterinarians\GetLicenseForUpdateUseCase;
use App\UseCase\Veterinarians\GetOrganizationExperiencesForUpdateUseCase;
use App\UseCase\Veterinarians\GetSpecializationsForUpdateUseCase;
use App\UseCase\Veterinarians\GetVeterinarianByIdUseCase;
use App\UseCase\Veterinarians\GetVeterinarianByUsernameUseCase;
use App\UseCase\Veterinarians\GetVeterinarianWalletUseCase;
use App\UseCase\Veterinarians\GetWorkingExperiencesForUpdateUseCase;
use App\UseCase\Veterinarians\UpdateBankAndTaxUseCase;
use App\UseCase\Veterinarians\UpdateEducationsUseCase;
use App\UseCase\Veterinarians\UpdateGeneralIdentityUseCase;
use App\UseCase\Veterinarians\UpdateLicenseUseCase;
use App\UseCase\Veterinarians\UpdateOrganizationExperiencesUseCase;
use App\UseCase\Veterinarians\UpdateSpecializationsUseCase;
use App\UseCase\Veterinarians\UpdateWorkingExperiencesUseCase;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class VeterinariansController extends Controller
{
    private $getVeterinarianByIdUseCase;
    private $getVeterinarianByUsernameUseCase;
    private $getAllVeterinarianUseCase;
    private $getVeterinarianWalletUseCase;
    private $updateGeneralIdentityUseCase;
    private $updateBankAndTaxUseCase;
    private $updateSpecializationsUseCase;
    private $updateWorkingExperiencesUseCase;
    private $updateOrganizationExperiencesUseCase;
    private $updateEducationsUseCase;
    private $updateLicenseUseCase;
    private $getGeneralIdentityForUpdateUseCase;
    private $getBankAndTaxForUpdateUseCase;
    private $getEducationsForUpdateUseCase;
    private $getLicenseForUpdateUseCase;
    private $getWorkingExperiencesForUpdateUseCase;
    private $getOrganizationExperiencesForUpdateUseCase;
    private $getSpecializationsForUpdateUseCase;

    public function __construct(
        VeterinarianRepository $veterinarianRepository,
        VeterinarianScheduleRepository $scheduleRepository,
        UserRepository $userRepository,
        WalletLogRepository $walletLogRepository
    ) {
        $this->getVeterinarianByIdUseCase = new GetVeterinarianByIdUseCase($veterinarianRepository, $scheduleRepository);
        $this->getVeterinarianByUsernameUseCase = new GetVeterinarianByUsernameUseCase($veterinarianRepository);
        $this->getAllVeterinarianUseCase = new GetAllVeterinarianUseCase($veterinarianRepository);
        $this->getVeterinarianWalletUseCase = new GetVeterinarianWalletUseCase($userRepository, $walletLogRepository);
        $this->updateGeneralIdentityUseCase = new UpdateGeneralIdentityUseCase($veterinarianRepository);
        $this->updateBankAndTaxUseCase = new UpdateBankAndTaxUseCase($veterinarianRepository);
        $this->updateSpecializationsUseCase = new UpdateSpecializationsUseCase($veterinarianRepository);
        $this->updateWorkingExperiencesUseCase = new UpdateWorkingExperiencesUseCase($veterinarianRepository);
        $this->updateOrganizationExperiencesUseCase = new UpdateOrganizationExperiencesUseCase($veterinarianRepository);
        $this->updateEducationsUseCase = new UpdateEducationsUseCase($veterinarianRepository);
        $this->updateLicenseUseCase = new UpdateLicenseUseCase($veterinarianRepository);
        $this->getGeneralIdentityForUpdateUseCase = new GetGeneralIdentityForUpdateUseCase($veterinarianRepository);
        $this->getBankAndTaxForUpdateUseCase = new GetBankAndTaxForUpdateUseCase($veterinarianRepository);
        $this->getEducationsForUpdateUseCase = new GetEducationsForUpdateUseCase($veterinarianRepository);
        $this->getLicenseForUpdateUseCase = new GetLicenseForUpdateUseCase($veterinarianRepository);
        $this->getWorkingExperiencesForUpdateUseCase = new GetWorkingExperiencesForUpdateUseCase($veterinarianRepository);
        $this->getOrganizationExperiencesForUpdateUseCase = new GetOrganizationExperiencesForUpdateUseCase($veterinarianRepository);
        $this->getSpecializationsForUpdateUseCase = new GetSpecializationsForUpdateUseCase($veterinarianRepository);
    }

    public function getById($id)
    {
        $responseArray = [
            "status" => "success",
            "data" => $this->getVeterinarianByIdUseCase->execute($id)->toArray()
        ];
        return response()->json($responseArray);
    }

    public function get()
    {
        $data = [];
        $username = request()->query('username');
        if ($username) {
            $data = $this->getVeterinarianByUsernameUseCase->execute($username);
        } else {
            $data = $this->getAllVeterinarianUseCase->execute();
        }
        $responseArray = [
            "status" => "success",
            "data" => $data
        ];
        return response()->json($responseArray);
    }

    public function getByUsername()
    {
        $username = request()->query('username');
        $responseArray = [
            "status" => "success",
            "data" => $this->getVeterinarianByUsernameUseCase->execute($username)
        ];
        return response()->json($responseArray);
    }

    public function getMyWallet(Request $request)
    {
        $responseArray = [
            "status" => "success",
            "data" => $this->getVeterinarianWalletUseCase->execute($request->user()->id)
        ];
        return response()->json($responseArray);
    }

    public function updateMyGeneralIdentity(Request $request)
    {
        $this->updateGeneralIdentityUseCase->execute($request->user()->id, new GeneralIdentity(
            $request->frontTitle,
            $request->backTitle,
            $request->dateOfBirth,
            $request->whatsappNumber,
            $request->formalPictureId,
            $request->nik,
            $request->ktpFileId,
            $request->biodata
        ));
        $responseArray = [
            "status" => "success",
            "message" => "General identity updated successfully."
        ];
        return response()->json($responseArray);
    }
    public function updateMySpecializations(Request $request)
    {
        $this->updateSpecializationsUseCase->execute(request()->user()->id, $request->specializations);
        $responseArray = [
            "status" => "success",
            "message" => "Specializations updated successfully."
        ];
        return response()->json($responseArray);
    }
    public function updateMyLicense(Request $request)
    {
        $this->updateLicenseUseCase->execute(request()->user()->id, new License(
            $request->strvFileId,
            $request->strvValidUntil,
            $request->strvNumber,
            $request->sipFileId,
            $request->sipValidUntil,
            $request->sipNumber
        ));
        $responseArray = [
            "status" => "success",
            "message" => "License updated successfully."
        ];
        return response()->json($responseArray);
    }
    public function updateMyEducations(Request $request)
    {
        $educations = array_map(function ($education) {
            return new Education(
                $education['institution'],
                $education['year'],
                $education['program'],
                $education['title']
            );
        }, $request->educations);
        $this->updateEducationsUseCase->execute(request()->user()->id, $educations);
        $responseArray = [
            "status" => "success",
            "message" => "Educations updated successfully."
        ];
        return response()->json($responseArray);
    }
    public function updateMyWorkingExperiences(Request $request)
    {
        $workingExperiences = array_map(function ($workingExperience) {
            return new WorkingExperience(
                $workingExperience['institution'],
                $workingExperience['year'],
                $workingExperience['position'],
                $workingExperience['isActive']
            );
        }, $request->workingExperiences);
        $this->updateWorkingExperiencesUseCase->execute(request()->user()->id, $workingExperiences);
        $responseArray = [
            "status" => "success",
            "message" => "Working experiences updated successfully."
        ];
        return response()->json($responseArray);
    }
    public function updateMyOrganizationExperiences(Request $request)
    {
        $organizationExperiences = array_map(function ($organizationExperience) {
            return new OrganizationExperience(
                $organizationExperience['institution'],
                $organizationExperience['year'],
                $organizationExperience['position'],
                $organizationExperience['isActive']
            );
        }, $request->organizationExperiences);
        $this->updateOrganizationExperiencesUseCase->execute(request()->user()->id, $organizationExperiences);
        $responseArray = [
            "status" => "success",
            "message" => "Organization experiences updated successfully."
        ];
        return response()->json($responseArray);
    }
    public function updateMyBankAndTax(Request $request)
    {
        $this->updateBankAndTaxUseCase->execute(request()->user()->id, new BankAndTax(
            $request->npwp,
            $request->npwpFileId,
            $request->bankName,
            $request->bankAccountNumber,
            $request->bankAccountFileId,
            $request->bankAccountName
        ));
        $responseArray = [
            "status" => "success",
            "message" => "Bank and tax updated successfully."
        ];
        return response()->json($responseArray);
    }

    public function getMyGeneralIdentity()
    {
        $responseArray = [
            "status" => "success",
            "data" => $this->getGeneralIdentityForUpdateUseCase->execute(request()->user()->id)->toArray()
        ];
        return response()->json($responseArray);
    }
    public function getMySpecializations()
    {
        $responseArray = [
            "status" => "success",
            "data" => $this->getSpecializationsForUpdateUseCase->execute(request()->user()->id)
        ];
        return response()->json($responseArray);
    }
    public function getMyLicense()
    {
        $responseArray = [
            "status" => "success",
            "data" => $this->getLicenseForUpdateUseCase->execute(request()->user()->id)->toArray()
        ];
        return response()->json($responseArray);
    }
    public function getMyEducations()
    {
        $responseArray = [
            "status" => "success",
            "data" => $this->getEducationsForUpdateUseCase->execute(request()->user()->id)
        ];
        return response()->json($responseArray);
    }
    public function getMyWorkingExperiences()
    {
        $responseArray = [
            "status" => "success",
            "data" => $this->getWorkingExperiencesForUpdateUseCase->execute(request()->user()->id)
        ];
        return response()->json($responseArray);
    }
    public function getMyOrganizationExperiences()
    {
        $responseArray = [
            "status" => "success",
            "data" => $this->getOrganizationExperiencesForUpdateUseCase->execute(request()->user()->id)
        ];
        return response()->json($responseArray);
    }
    public function getMyBankAndTax()
    {
        $responseArray = [
            "status" => "success",
            "data" => $this->getBankAndTaxForUpdateUseCase->execute(request()->user()->id)->toArray()
        ];
        return response()->json($responseArray);
    }
}
