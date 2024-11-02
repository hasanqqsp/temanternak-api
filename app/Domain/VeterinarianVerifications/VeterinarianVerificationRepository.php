<?php

namespace App\Domain\VeterinarianVerifications;

use App\Domain\VeterinarianVerifications\Entities\AddedVeterinarianVerification;
use App\Domain\VeterinarianVerifications\Entities\EditVeterinarianVerification;
use App\Domain\VeterinarianVerifications\Entities\NewVeterinarianVerification;

interface VeterinarianVerificationRepository
{
    public function checkIfExists(string $registrationId);
    public function add(NewVeterinarianVerification $data): AddedVeterinarianVerification;
    public function edit(EditVeterinarianVerification $data): void;
}
