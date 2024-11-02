<?php

namespace App\Infrastructure\Repository\Eloquent;

use App\Domain\VeterinarianVerifications\Entities\AddedVeterinarianVerification;
use App\Domain\VeterinarianVerifications\Entities\EditVeterinarianVerification;
use App\Domain\VeterinarianVerifications\Entities\NewVeterinarianVerification;
use App\Domain\VeterinarianVerifications\VeterinarianVerificationRepository;
use App\Infrastructure\Repository\Models\VeterinarianRegistration;
use App\Infrastructure\Repository\Models\VeterinarianVerification;

class VeterinarianVerificationRepositoryEloquent implements VeterinarianVerificationRepository
{
    public function add(NewVeterinarianVerification $data): AddedVeterinarianVerification
    {
        $verification = new VeterinarianVerification();
        $verification->status = $data->getStatus();
        $verification->message = $data->getMessage();
        $verification->comments = $data->getComments();
        $verification->verificator_id = $data->getVerificatorId();

        $registrationData = VeterinarianRegistration::find($data->getRegistrationId());
        $registrationData->verificationResult()->save($verification);
        $registrationData->status = $verification->status;
        $registrationData->save();
        return new AddedVeterinarianVerification(
            $registrationData->id,
            $verification->status
        );
    }

    public function checkIfExists($registrationId): bool
    {
        $registration = VeterinarianRegistration::find($registrationId);
        if (!$registration || !$registration->verificationResult->exists()) {
            throw new \Exception("Verification does not exist for registration ID: $registrationId");
        }
        return true;
    }

    public function edit(EditVeterinarianVerification $data): void
    {
        $verification = new VeterinarianVerification();
        $verification->status = $data->getStatus();
        $verification->message = $data->getMessage();
        $verification->comments = $data->getComments();

        $registrationData = VeterinarianRegistration::find($data->getRegistrationId());

        $registrationData->verificationResult()->save($verification);
        $registrationData->status = $verification->status;
        $registrationData->save();
    }
}
