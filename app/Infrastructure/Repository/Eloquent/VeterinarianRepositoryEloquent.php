<?php

namespace App\Infrastructure\Repository\Eloquent;

use App\Commons\Utils\StringUtils;
use App\Domain\VeterinarianRegistrations\Entities\Education;
use App\Domain\VeterinarianRegistrations\Entities\OrganizationExperience;
use App\Domain\VeterinarianRegistrations\Entities\WorkingExperience;
use App\Domain\Veterinarians\Entities\Veterinarian;
use App\Domain\Veterinarians\Entities\VeterinarianShort;
use App\Domain\Veterinarians\VeterinarianRepository;
use App\Domain\VeterinarianServices\Entities\VetServiceOnly;
use App\Infrastructure\Repository\Models\User;


class VeterinarianRepositoryEloquent implements VeterinarianRepository
{
    private function mapUserToVeterinarian(User $user): Veterinarian
    {
        $registrationData = $user->veterinarianRegistration->where("status", "ACCEPTED")->first();
        $frontTitle = $registrationData->generalIdentity->front_title;
        $backTitle = $registrationData->generalIdentity->back_title;
        $nameAndTitle = StringUtils::nameAndTitle($frontTitle, $user->name, $backTitle);
        $license = $registrationData->license;
        $educations = $registrationData->educations()->map(function ($educationData) {
            return (new Education(
                $educationData->institution,
                $educationData->year,
                $educationData->program,
                $educationData->title
            ))->toArray();
        })->toArray();

        $workingExperiences =  $registrationData
            ->workingExperiences()->map(function ($workingExperienceData) {
                return (new WorkingExperience(
                    $workingExperienceData->institution,
                    $workingExperienceData->year,
                    $workingExperienceData->position,
                    $workingExperienceData->is_active
                ))->toArray();
            })->toArray();

        $organizationExperiences = $registrationData
            ->organizationExperiences()->map(function ($organizationExperienceData) {
                return (new OrganizationExperience(
                    $organizationExperienceData->institution,
                    $organizationExperienceData->year,
                    $organizationExperienceData->position,
                    $organizationExperienceData->is_active
                ))->toArray();
            },)->toArray();
        $services = $user->services->whereNotNull('approved_at')
            ->whereNull('suspended_at')->map(function ($service) {
                return (new VetServiceOnly(
                    $service->id,
                    $service->price,
                    $service->duration,
                    $service->description,
                    $service->name
                ))->toArray();
            })->toArray();

        return new Veterinarian(
            $user->id,
            $nameAndTitle,
            $license->strv_number,
            $license->strv_valid_until,
            $license->sip_number,
            $license->sip_valid_until,
            $registrationData->verificationResult->updated_at->format('Y-m-d\TH:i:s.up'),
            $user->username,
            $registrationData->generalIdentity->formalPhoto->file_path,
            $registrationData->specializations,
            $educations,
            $workingExperiences,
            $organizationExperiences,
            $registrationData->generalIdentity->biodata,
            $services
        );
    }

    private function mapUserToVeterinarianShort(User $user): VeterinarianShort
    {
        $registrationData = $user->veterinarianRegistration->where("status", "ACCEPTED")->first();
        $frontTitle = $registrationData->generalIdentity->front_title;
        $backTitle = $registrationData->generalIdentity->back_title;
        $nameAndTitle = $frontTitle . " " . $user->name . ", " . $backTitle;

        return new VeterinarianShort(
            $user->id,
            $nameAndTitle,
            $user->username,
            $registrationData->generalIdentity->formalPhoto->file_path,
            $registrationData->specializations,
        );
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
            return $this->mapUserToVeterinarianShort($user);
        })->toArray();
    }
}
