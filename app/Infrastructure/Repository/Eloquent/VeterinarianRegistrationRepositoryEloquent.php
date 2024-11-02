<?php

namespace App\Infrastructure\Repository\Eloquent;

use App\Commons\Exceptions\ClientException;
use App\Commons\Exceptions\UserInputException;
use App\Domain\Invitations\Entities\Invitation;
use App\Domain\Invitations\Entities\ShortInvitation;
use App\Domain\Users\Entities\ShortUser;
use App\Domain\Users\Entities\User;
use App\Domain\VeterinarianRegistrations\Entities\AddedVeterinarianRegistration;
use App\Domain\VeterinarianRegistrations\Entities\BankAndTaxResponse;
use App\Domain\VeterinarianRegistrations\Entities\Education as EntitiesEducation;
use App\Domain\VeterinarianRegistrations\Entities\LicenseResponse;
use App\Domain\VeterinarianRegistrations\Entities\NewVetRegistration;
use App\Domain\VeterinarianRegistrations\Entities\OrganizationExperience as EntitiesOrganizationExperience;
use App\Domain\VeterinarianRegistrations\Entities\ShortVeterinarianRegistration;
use App\Domain\VeterinarianRegistrations\Entities\VeterinarianRegistration as EntitiesVeterinarianRegistration;
use App\Domain\VeterinarianRegistrations\Entities\WorkingExperience as EntitiesWorkingExperience;
use App\Domain\VeterinarianRegistrations\VeterinarianRegistrationRepository;
use App\Infrastructure\Repository\Models\BankAndTax;
use App\Infrastructure\Repository\Models\Education;
use App\Infrastructure\Repository\Models\GeneralIdentity;
use App\Infrastructure\Repository\Models\License;
use App\Infrastructure\Repository\Models\OrganizationExperience;
use App\Infrastructure\Repository\Models\VeterinarianRegistration;
use App\Infrastructure\Repository\Models\WorkingExperience;

class VeterinarianRegistrationRepositoryEloquent implements VeterinarianRegistrationRepository
{
    public function checkIfExists($registrationId)
    {
        if (!VeterinarianRegistration::where('id', $registrationId)->exists()) {
            throw new ClientException("The registration with ID $registrationId does not exist.");
        }
    }

    public function verifyIsPending($registrationId)
    {
        $registration = VeterinarianRegistration::find($registrationId);
        if ($registration && $registration->status !== 'PENDING') {
            throw new ClientException(
                "The registration with ID $registrationId not need verification because status is ($registration->status)."
            );
        }
    }

    public function verifyNotRevised($registrationId)
    {
        $registration = VeterinarianRegistration::find($registrationId);
        if ($registration->revised_by) {
            throw new ClientException(
                "The registration with ID $registrationId has already been revised."
            );
        }
    }

    public function verifyNotAccepted($registrationId)
    {
        $registration = VeterinarianRegistration::find($registrationId);
        if ($registration && $registration->status === 'ACCEPTED') {
            throw new ClientException(
                "The registration with ID $registrationId has already been accepted."
            );
        }
    }
    public function verifyExistsForInvitation($invitationId)
    {
        if (!VeterinarianRegistration::where('invitation_id', $invitationId)->exists()) {
            throw new UserInputException(
                "Not yet any verterinarian registration for invitation ID $invitationId",
                [
                    "invitationId" => "The invitation ID is not found in the system"
                ]
            );
        }
        return true;
    }

    public function getByUserId($userId): array
    {
        $registrations = VeterinarianRegistration::where('user_id', $userId)->orderBy('created_at', 'desc')->get();
        return $registrations->map(function ($registrationData) {
            return $this->createVeterinarianRegistrationEntity($registrationData)->toArray();
        })->toArray();
    }
    // Implement the methods defined in VeterinarianRegistrationRepository

    public function markRevisedBy(string $revisedId, string $revisingId)
    {
        $registration = VeterinarianRegistration::find($revisedId);
        $registration->revised_by = $revisingId;
        $registration->status = 'REVISED';
        $registration->save();
    }

    public function markReviewedBy(string $id, string $reviewerId)
    {
        $registration = VeterinarianRegistration::find($id);
        $registration->reviewed_by = $reviewerId;
        $registration->save();
    }

    public function markRevising(string $revisingId, string $revisedId)
    {
        $registration = VeterinarianRegistration::find($revisingId);
        $registration->revising_registration_id = $revisedId;
        $registration->save();
    }

    public function createVeterinarianRegistrationEntity($registrationData)
    {
        $educations = $registrationData->educations()->map(function ($educationData) {
            return new EntitiesEducation(
                $educationData->institution,
                $educationData->year,
                $educationData->program,
                $educationData->title
            );
        });

        $workingExperiences =  $registrationData
            ->workingExperiences()->map(function ($workingExperienceData) {
                return new EntitiesWorkingExperience(
                    $workingExperienceData->institution,
                    $workingExperienceData->year,
                    $workingExperienceData->position,
                    $workingExperienceData->is_active
                );
            });

        $organizationExperiences = $registrationData
            ->organizationExperiences()->map(function ($organizationExperienceData) {
                return new EntitiesOrganizationExperience(
                    $organizationExperienceData->institution,
                    $organizationExperienceData->year,
                    $organizationExperienceData->position,
                    $organizationExperienceData->is_active
                );
            },);

        $registration =  new EntitiesVeterinarianRegistration(
            $registrationData->id,
            $registrationData->status,
            new User(
                $registrationData->user->id,
                $registrationData->user->name,
                $registrationData->user->email,
                $registrationData->user->created_at,
                $registrationData->user->updated_at,
                $registrationData->user->role,
                $registrationData->user->phone,
                $registrationData->user->username,
            ),
            $registrationData->generalIdentity->front_title,
            $registrationData->generalIdentity->back_title,
            $registrationData->generalIdentity->date_of_birth,
            $registrationData->generalIdentity->whatsapp_number,
            $registrationData->generalIdentity->formalPhoto->file_path,
            $registrationData->generalIdentity->nik,
            $registrationData->generalIdentity->ktpFile->file_path,
            $registrationData->created_at,
            $registrationData->updated_at,
            $registrationData->specializations,
            new LicenseResponse(
                $registrationData->license->strv_number,
                $registrationData->license->strvFile->file_path,
                $registrationData->license->strv_valid_until,
                $registrationData->license->sip_number,
                $registrationData->license->sipFile->file_path,
                $registrationData->license->sip_valid_until
            ),
            $educations->toArray(),
            $workingExperiences->toArray(),
            $organizationExperiences->toArray(),
            new BankAndTaxResponse(
                $registrationData->bankAndTax->npwp,
                $registrationData->bankAndTax->npwpFile->file_path,
                $registrationData->bankAndTax->bank_account_name,
                $registrationData->bankAndTax->bank_name,
                $registrationData->bankAndTax->bank_account_number,
                $registrationData->bankAndTax->bankAccountFile->file_path
            ),
            new Invitation(
                $registrationData->invitation->id,
                $registrationData->invitation->email,
                $registrationData->invitation->name,
                new ShortUser(
                    $registrationData->invitation->inviter->id,
                    $registrationData->invitation->inviter->name,
                    $registrationData->invitation->inviter->role,
                ),
                $registrationData->invitation->message,
                $registrationData->invitation->phone,
                $registrationData->invitation->created_at,
                $registrationData->invitation->updated_at,
                $registrationData->invitation->is_revoked
            ),
            $registrationData->generalIdentity->biodata,
        );
        if ($registrationData->verificationResult) {
            $registration->setVerificationResult($registrationData->verificationResult);
        }
        if ($registrationData->verificationResult) {
            $registration->setVerificationResult($registrationData->verificationResult);
        }
        return $registration;
    }

    public function verifyNotExistsForInvitation($invitationId)
    {
        if (VeterinarianRegistration::where('invitation_id', $invitationId)->exists()) {
            throw new UserInputException(
                "Veterinarian registration with invitation ID $invitationId already exists. Please revise the existing registration.",
                [
                    "revisingId" => "Add revisingId property to the request body and set it to the ID of the existing last registration",
                ]
            );
        }
        return true;
    }

    public function getById($id): EntitiesVeterinarianRegistration
    {
        $registrationData = VeterinarianRegistration::find($id);


        return $this->createVeterinarianRegistrationEntity($registrationData);
    }

    public function getAll(): array
    {
        return VeterinarianRegistration::all()->map(
            function ($registrationData) {
                return (new ShortVeterinarianRegistration(
                    $registrationData->id,
                    $registrationData->status,
                    (new ShortUser(
                        $registrationData->user_id,
                        $registrationData->user->name,
                        $registrationData->user->role,
                    )),
                    $registrationData->generalIdentity->whatsapp_number,
                    $registrationData->generalIdentity->formalPhoto->file_path,
                    $registrationData->created_at,
                    $registrationData->updated_at,

                    new ShortInvitation(
                        $registrationData->invitation->id,
                        (new ShortUser(
                            $registrationData->invitation->inviter->id,
                            $registrationData->invitation->inviter->name,
                            $registrationData->invitation->inviter->role,
                        )),
                        $registrationData->invitation->message,
                        $registrationData->invitation->created_at
                    )
                ))->toArray();
            }
        )->toArray();
    }

    public function create(NewVetRegistration $data): AddedVeterinarianRegistration
    {
        $registration = new VeterinarianRegistration();
        $registration->status = "PENDING"; // REJECTED, APPROVED
        $registration->user_id = $data->getUserId();
        $registration->invitation_id = $data->getInvitationId();
        $registration->specializations = $data->getSpecializations();

        $registration->save();

        $generalIdentity = new GeneralIdentity();
        $generalIdentity->front_title = $data->getGeneralIdentity()->getFrontTitle();
        $generalIdentity->back_title = $data->getGeneralIdentity()->getBackTitle();
        $generalIdentity->date_of_birth = $data->getGeneralIdentity()->getDateOfBirth();
        $generalIdentity->whatsapp_number = $data->getGeneralIdentity()->getWhatsappNumber();
        $generalIdentity->formal_picture_id = $data->getGeneralIdentity()->getFormalPictureId();
        $generalIdentity->nik = $data->getGeneralIdentity()->getNik();
        $generalIdentity->ktp_file_id = $data->getGeneralIdentity()->getKtpFileId();
        $generalIdentity->biodata = $data->getGeneralIdentity()->getBiodata();

        $registration->generalIdentity()->save($generalIdentity);
        $license = new License();
        $license->strv_number = $data->getLicense()->getStrvNumber();
        $license->strv_file_id = $data->getLicense()->getStrvFileId();
        $license->strv_valid_until = $data->getLicense()->getStrvValidUntil();
        $license->sip_number = $data->getLicense()->getSipNumber();
        $license->sip_file_id = $data->getLicense()->getSipFileId();
        $license->sip_valid_until = $data->getLicense()->getSipValidUntil();

        $registration->license()->save($license);


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
            $workingExperience->position = $workingExperienceData->getPosition();
            $workingExperience->is_active = $workingExperienceData->getIsActive();
            $registration->workingExperiences()->attach($workingExperience);
        }
        foreach ($data->getOrganizationExperiences() as $organizationExperienceData) {
            $organizationExperience = new OrganizationExperience();
            $organizationExperience->institution = $organizationExperienceData->getInstitution();
            $organizationExperience->year = $organizationExperienceData->getYear();
            $organizationExperience->position = $organizationExperienceData->getPosition();
            $organizationExperience->is_active = $organizationExperienceData->getIsActive();
            $registration->organizationExperiences()->attach($organizationExperience);
        }

        $bankAndTax = new BankAndTax();
        $bankAndTax->bank_account_name = $data->getBankAndTax()->getBankAccountName();
        $bankAndTax->bank_name = $data->getBankAndTax()->getBankName();
        $bankAndTax->bank_account_number = $data->getBankAndTax()->getBankAccountNumber();
        $bankAndTax->npwp = $data->getBankAndTax()->getNpwp();
        $bankAndTax->npwp_file_id = $data->getBankAndTax()->getNpwpFileId();
        $bankAndTax->bank_account_file_id = $data->getBankAndTax()->getBankAccountFileId();
        $registration->bankAndTax()->save($bankAndTax);

        return new AddedVeterinarianRegistration(
            $registration->id,
            $registration->status,
            $registration->user_id,
            $registration->invitation_id,
        );
    }
}
