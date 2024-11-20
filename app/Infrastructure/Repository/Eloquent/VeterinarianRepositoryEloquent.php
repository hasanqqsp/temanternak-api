<?php

namespace App\Infrastructure\Repository\Eloquent;

use App\Commons\Exceptions\NotFoundException;
use App\Commons\Utils\StringUtils;
use App\Domain\VeterinarianRegistrations\Entities\BankAndTax as EntitiesBankAndTax;
use App\Domain\VeterinarianRegistrations\Entities\Education as EntitiesEducation;
use App\Domain\VeterinarianRegistrations\Entities\GeneralIdentity as EntitiesGeneralIdentity;
use App\Domain\VeterinarianRegistrations\Entities\License as EntitiesLicense;
use App\Domain\VeterinarianRegistrations\Entities\OrganizationExperience as EntitiesOrganizationExperience;
use App\Domain\VeterinarianRegistrations\Entities\WorkingExperience as EntitiesWorkingExperience;
use App\Domain\Veterinarians\Entities\Veterinarian;
use App\Domain\Veterinarians\Entities\VeterinarianShort;
use App\Domain\Veterinarians\Entities\VeterinarianShortForList;
use App\Domain\Veterinarians\VeterinarianRepository;
use App\Domain\VeterinarianSchedules\Entities\VeterinarianSchedule;
use App\Domain\VeterinarianServices\Entities\VetServiceOnly;
use App\Infrastructure\Repository\Models\BankAndTax;
use App\Infrastructure\Repository\Models\Education;
use App\Infrastructure\Repository\Models\GeneralIdentity;
use App\Infrastructure\Repository\Models\License;
use App\Infrastructure\Repository\Models\OrganizationExperience;
use App\Infrastructure\Repository\Models\User;
use App\Infrastructure\Repository\Models\Veterinarian as ModelsVeterinarian;
use App\Infrastructure\Repository\Models\VeterinarianRegistration;
use App\Infrastructure\Repository\Models\WorkingExperience;
use Tymon\JWTAuth\JWT;

class VeterinarianRepositoryEloquent implements VeterinarianRepository
{
    public function getVeterinarianGeneralIdentity($id): EntitiesGeneralIdentity
    {
        $user = User::find($id);
        return (new EntitiesGeneralIdentity(
            $user->data->generalIdentity->front_title,
            $user->data->generalIdentity->back_title,
            $user->data->generalIdentity->date_of_birth,
            $user->data->generalIdentity->whatsapp_number,
            $user->data->generalIdentity->formal_picture_id,
            $user->data->generalIdentity->nik,
            $user->data->generalIdentity->ktp_file_id,
            $user->data->generalIdentity->biodata
        ));
    }

    public function getVeterinarianLicense($id): EntitiesLicense
    {
        $user = User::find($id);
        return (new EntitiesLicense(
            $user->data->license->strv_file_id,
            $user->data->license->strv_valid_until,
            $user->data->license->strv_number,
            $user->data->license->sip_file_id,
            $user->data->license->sip_valid_until,
            $user->data->license->sip_number
        ));
    }

    public function getVeterinarianSpecializations($id): array
    {
        $user = User::find($id);
        return $user->data->specializations;
    }

    public function getVeterinarianEducations($id): array
    {
        $user = User::find($id);
        return $user->data->educations->map(function ($educationData) {
            return (new EntitiesEducation(
                $educationData->institution,
                $educationData->year,
                $educationData->program,
                $educationData->title
            ))->toArray();
        })->toArray();
    }

    public function getVeterinarianWorkingExperiences($id): array
    {
        $user = User::find($id);
        return $user->data->workingExperiences->map(function ($workingExperienceData) {
            return (new EntitiesWorkingExperience(
                $workingExperienceData->institution,
                $workingExperienceData->year,
                $workingExperienceData->position,
                $workingExperienceData->is_active
            ))->toArray();
        })->toArray();
    }

    public function getVeterinarianOrganizationExperiences($id): array
    {
        $user = User::find($id);
        return $user->data->organizationExperiences->map(function ($organizationExperienceData) {
            return (new EntitiesOrganizationExperience(
                $organizationExperienceData->institution,
                $organizationExperienceData->year,
                $organizationExperienceData->position,
                $organizationExperienceData->is_active
            ))->toArray();
        })->toArray();
    }

    public function getVeterinarianBankAndTax($id): EntitiesBankAndTax
    {
        $user = User::find($id);
        return new EntitiesBankAndTax(
            $user->data->bankAndTax->npwp,
            $user->data->bankAndTax->npwp_file_id,
            $user->data->bankAndTax->bank_name,
            $user->data->bankAndTax->bank_account_number,
            $user->data->bankAndTax->bank_account_file_id,
            $user->data->bankAndTax->bank_account_name,
        );
    }

    public function updateGeneralIdentity($id, $data)
    {
        $generalIdentity = new GeneralIdentity();
        $generalIdentity->front_title = $data->getFrontTitle();
        $generalIdentity->back_title = $data->getBackTitle();
        $generalIdentity->date_of_birth = $data->getDateOfBirth();
        $generalIdentity->whatsapp_number = $data->getWhatsappNumber();
        $generalIdentity->formal_picture_id = $data->getFormalPictureId();
        $generalIdentity->nik = $data->getNik();
        $generalIdentity->ktp_file_id = $data->getKtpFileId();
        $generalIdentity->biodata = $data->getBiodata();
        $user = User::find($id);
        $user->data->generalIdentity()->save($generalIdentity);
    }

    public function updateSpecializations($id, $specializations)
    {
        $user = User::find($id);
        $user->data->specializations = $specializations;
        $user->data->save();
    }

    public function updateLicense($id, $license)
    {
        $newLicense = new License();
        $newLicense->strv_number = $license->getStrvNumber();
        $newLicense->strv_file_id = $license->getStrvFileId();
        $newLicense->strv_valid_until = $license->getStrvValidUntil();
        $newLicense->sip_number = $license->getSipNumber();
        $newLicense->sip_file_id = $license->getSipFileId();
        $newLicense->sip_valid_until = $license->getSipValidUntil();

        $user = User::find($id);
        $user->data->license()->save($newLicense);
    }

    public function updateEducations($id, $educations)
    {
        $user = User::find($id);
        $user->data->educations()->delete();
        foreach ($educations as $educationData) {
            $education = new Education();
            $education->institution = $educationData->getInstitution();
            $education->year = $educationData->getYear();
            $education->program = $educationData->getProgram();
            $education->title = $educationData->getTitle();
            $user->data->educations()->attach($education);
        }
    }

    public function updateWorkingExperiences($id, $workingExperiences)
    {
        $user = User::find($id);
        $user->data->workingExperiences()->delete();
        foreach ($workingExperiences as $workingExperienceData) {
            $workingExperience = new WorkingExperience();
            $workingExperience->institution = $workingExperienceData->getInstitution();
            $workingExperience->year = $workingExperienceData->getYear();
            $workingExperience->position = $workingExperienceData->getPosition();
            $workingExperience->is_active = $workingExperienceData->getIsActive();
            $user->data->workingExperiences()->attach($workingExperience);
        }
    }

    public function updateOrganizationExperiences($id, $organizationExperiences)
    {
        $user = User::find($id);
        $user->data->organizationExperiences()->delete();
        foreach ($organizationExperiences as $organizationExperienceData) {
            $organizationExperience = new OrganizationExperience();
            $organizationExperience->institution = $organizationExperienceData->getInstitution();
            $organizationExperience->year = $organizationExperienceData->getYear();
            $organizationExperience->position = $organizationExperienceData->getPosition();
            $organizationExperience->is_active = $organizationExperienceData->getIsActive();
            $user->data->organizationExperiences()->attach($organizationExperience);
        }
    }

    public function updateBankAndTax($id, $bankAndTax)
    {
        $updatedBankAndTax = new BankAndTax();
        $updatedBankAndTax->bank_account_name = $bankAndTax->getBankAccountName();
        $updatedBankAndTax->bank_name = $bankAndTax->getBankName();
        $updatedBankAndTax->bank_account_number = $bankAndTax->getBankAccountNumber();
        $updatedBankAndTax->npwp = $bankAndTax->getNpwp();
        $updatedBankAndTax->npwp_file_id = $bankAndTax->getNpwpFileId();
        $updatedBankAndTax->bank_account_file_id = $bankAndTax->getBankAccountFileId();

        $user = User::find($id);
        $user->data->bankAndTax()->save($updatedBankAndTax);
    }

    public function checkIfExists($id)
    {
        if (!User::find($id) || User::find($id)->role != 'veterinarian') {
            throw new NotFoundException("Veterinarian not found");
        }
    }

    private function mapUserToVeterinarian(?User $user): Veterinarian
    {
        if (!$user->data) {
            $this->populate($user->veterinarianRegistration->where("status", "ACCEPTED")->first());
        }
        $user = User::find($user->id);
        $data = $user->data;
        // dd($user);
        $frontTitle = $data->generalIdentity->front_title;
        $backTitle = $data->generalIdentity->back_title;
        $nameAndTitle = StringUtils::nameAndTitle($frontTitle, $user->name, $backTitle);
        $license = $data->license;
        $educations = $data->educations()->map(function ($educationData) {
            return (new EntitiesEducation(
                $educationData->institution,
                $educationData->year,
                $educationData->program,
                $educationData->title
            ))->toArray();
        })->toArray();

        $workingExperiences =  $data
            ->workingExperiences()->map(function ($workingExperienceData) {
                return (new EntitiesWorkingExperience(
                    $workingExperienceData->institution,
                    $workingExperienceData->year,
                    $workingExperienceData->position,
                    $workingExperienceData->is_active
                ))->toArray();
            })->toArray();

        $organizationExperiences = $data
            ->organizationExperiences()->map(function ($organizationExperienceData) {
                return (new EntitiesOrganizationExperience(
                    $organizationExperienceData->institution,
                    $organizationExperienceData->year,
                    $organizationExperienceData->position,
                    $organizationExperienceData->is_active
                ))->toArray();
            },)->toArray();

        $services = array_values($user->services->whereNotNull('approved_at')
            ->whereNull('suspended_at')->whereNull("deleted_at")->map(function ($service) {
                return (new VetServiceOnly(
                    $service->id,
                    $service->price,
                    $service->duration,
                    $service->description,
                    $service->name
                ))->toArray();
            })->toArray());

        return new Veterinarian(
            $user->id,
            $nameAndTitle,
            $license->strv_number,
            $license->strv_valid_until,
            $license->sip_number,
            $license->sip_valid_until,
            $data->registered_at->format('Y-m-d\TH:i:s.up'),
            $user->username,
            $data->generalIdentity->formalPhoto->file_path,
            $data->specializations,
            $educations,
            $workingExperiences,
            $organizationExperiences,
            $data->generalIdentity->biodata,
            $services
        );
    }

    private function mapUserToVeterinarianShort(?User $user): VeterinarianShortForList
    {
        if (!$user->data) {
            $this->populate($user->veterinarianRegistration->where("status", "ACCEPTED")->first());
        }

        $user = User::find($user->id);
        $data = $user->data;

        $frontTitle = $data->generalIdentity->front_title;
        $backTitle = $data->generalIdentity->back_title;
        $nameAndTitle = StringUtils::nameAndTitle($frontTitle, $user->name, $backTitle);
        return new VeterinarianShortForList(
            $user->id,
            $nameAndTitle,
            $user->username,
            $data->generalIdentity->formalPhoto->file_path,
            $data->specializations,
            $data->generalIdentity->whatsapp_number,
            $data->license->sip_number,
            $data->license->strv_number
        );
    }

    public function populate($veterinarianRegistration)
    {
        $veterinarian = new ModelsVeterinarian();
        $veterinarian->user_id = $veterinarianRegistration->user_id;
        $veterinarian->specializations = $veterinarianRegistration->specializations;
        $veterinarian->registered_at = $veterinarianRegistration->verificationResult->updated_at;
        $veterinarian->save();
        // dd($veterinarian->generalIdentity());
        $veterinarian->generalIdentity()->save($veterinarianRegistration->generalIdentity->replicate());
        foreach ($veterinarianRegistration->educations as $education) {
            $veterinarian->educations()->attach($education->replicate());
        }
        $veterinarian->license()->save($veterinarianRegistration->license->replicate());
        foreach ($veterinarianRegistration->organizationExperiences as $organizationExperience) {
            $veterinarian->organizationExperiences()->attach($organizationExperience->replicate());
        }
        foreach ($veterinarianRegistration->workingExperiences as $workingExperience) {
            $veterinarian->workingExperiences()->attach($workingExperience->replicate());
        }

        $veterinarian->save();
    }

    public function getById(string $id): Veterinarian
    {
        $user = User::find($id);
        return $this->mapUserToVeterinarian($user);
    }

    public function getByUsername(string $username): Veterinarian
    {
        $user = User::where('username', $username)->first();
        return $this->mapUserToVeterinarian($user);
    }

    public function getAll(): array
    {
        return User::where("role", "veterinarian")->get()->map(function ($user) {
            return $this->mapUserToVeterinarianShort($user)->toArray();
        })->toArray();
    }
}
