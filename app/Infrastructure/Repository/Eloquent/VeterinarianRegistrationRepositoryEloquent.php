<?php

namespace App\Infrastructure\Repository\Eloquent;

use App\Domain\Users\VeterinarianRegistrationRepository;
use App\Domain\Users\VeterinarianRegistrationsRepository;
use App\Domain\VeterinarianRegistrations\Entities\AddedVeterinarianRegistration;
use App\Domain\VeterinarianRegistrations\Entities\NewVetRegistration;
use App\Infrastructure\Repository\Models\BankAndTax;
use App\Infrastructure\Repository\Models\Education;
use App\Infrastructure\Repository\Models\GeneralIdentity;
use App\Infrastructure\Repository\Models\License;
use App\Infrastructure\Repository\Models\OrganizationExperience;
use App\Infrastructure\Repository\Models\VeterinarianRegistrations;
use App\Infrastructure\Repository\Models\WorkingExperience;

class VeterinarianRegistrationRepositoryEloquent implements VeterinarianRegistrationRepository
{
    // Implement the methods defined in VeterinarianRegistrationRepository

    public function create(NewVetRegistration $data): AddedVeterinarianRegistration
    {
        $registration = new VeterinarianRegistrations();
        $registration->status = "PENDING"; // REJECTED, APPROVED

        $generalIdentity = new GeneralIdentity();
        $generalIdentity->front_title = $data->getGeneralIdentity()->getFrontTitle();
        $generalIdentity->back_title = $data->getGeneralIdentity()->getBackTitle();
        $generalIdentity->date_of_birth = $data->getGeneralIdentity()->getDateOfBirth();
        $generalIdentity->whatsapp_number = $data->getGeneralIdentity()->getWhatsappNumber();
        $generalIdentity->formal_picture_id = $data->getGeneralIdentity()->getFormalPictureId();
        $generalIdentity->nik = $data->getGeneralIdentity()->getNik();
        $generalIdentity->ktp_file_id = $data->getGeneralIdentity()->getKtpFileId();

        $registration->generalIdentity()->attach($generalIdentity);

        $license = new License();
        $license->strv_number = $data->getLicense()->getStrvNumber();
        $license->strv_file_id = $data->getLicense()->getStrvFileId();
        $license->strv_valid_until = $data->getLicense()->getStrvValidUntil();
        $license->sip_number = $data->getLicense()->getSipNumber();
        $license->sip_file_id = $data->getLicense()->getSipFileId();
        $license->sip_valid_until = $data->getLicense()->getSipValidUntil();

        $registration->license()->attach($license);

        $registration->specializations = $data->getSpecializations();

        foreach ($data->getEducations() as $educationData) {
            $education = new Education();
            $education->institution = $educationData->getInstitution();
            $education->year = $educationData->getYear();
            $education->program = $educationData->getProgram();
            $education->title = $educationData->getTitle();
            $registration->educations()->attach($education);
        }

        foreach ($data->getWorkingExperiences() as $workingExperienceData) {
            $workingExperience = new WorkingExperience();
            $workingExperience->institution = $workingExperienceData->getInstitution();
            $workingExperience->year = $workingExperienceData->getYear();
            $workingExperience->position = $workingExperienceData->getProgram();
            $workingExperience->is_active = $workingExperienceData->getTitle();
            $registration->workingExperiences()->attach($workingExperience);
        }
        foreach ($data->getOrganizationExperiences() as $organizationExperienceData) {
            $organizationExperience = new OrganizationExperience();
            $organizationExperience->institution = $organizationExperienceData->getInstitution();
            $organizationExperience->year = $organizationExperienceData->getYear();
            $organizationExperience->position = $organizationExperienceData->getProgram();
            $organizationExperience->is_active = $organizationExperienceData->getTitle();
            $registration->organizationExperiences()->attach($organizationExperience);
        }

        $bankAndTax = new BankAndTax();
        $bankAndTax->bank_name = $data->getBankAndTax()->getBankName();
        $bankAndTax->bank_account_number = $data->getBankAndTax()->getBankAccountNumber();
        $bankAndTax->npwp = $data->getBankAndTax()->getNpwp();
        $bankAndTax->npwp_file_id = $data->getBankAndTax()->getNpwpFileId();
        $bankAndTax->bank_account_file_id = $data->getBankAndTax()->getBankAccountFileId();
        $registration->bankAndTax()->attach($bankAndTax);

        $registration->save();

        return new AddedVeterinarianRegistration(
            $registration->id,
            $registration->status,
            $registration->generalIdentity(),
            $registration->license(),
            $registration->specializations,
            $registration->educations(),
            $registration->workingExperiences(),
            $registration->organizationExperiences(),
            $registration->bankAndTax()
        );
    }
}
