<?php

namespace App\Domain\Users;

use App\Domain\VeterinarianRegistrations\Entities\AddedVeterinarianRegistration;
use App\Domain\VeterinarianRegistrations\Entities\NewVetRegistration;

interface VeterinarianRegistrationRepository
{
    public function create(NewVetRegistration $userData): AddedVeterinarianRegistration;
}
