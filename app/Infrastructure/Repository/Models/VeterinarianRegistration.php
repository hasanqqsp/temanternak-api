<?php

namespace App\Infrastructure\Repository\Models;

use MongoDB\Laravel\Eloquent\Model;

class VeterinarianRegistrations extends Model
{
    public function generalIdentity()
    {
        return $this->embedsOne(GeneralIdentity::class);
    }
    public function bankAndTax()
    {
        return $this->embedsOne(BankAndTax::class);
    }
    public function educations()
    {
        return $this->embedsMany(Education::class);
    }
    public function organizationExperiences()
    {
        return $this->embedsMany(OrganizationExperience::class);
    }
    public function workingExperiences()
    {
        return $this->embedsMany(WorkingExperience::class);
    }
    public function license()
    {
        return $this->embedsOne(License::class);
    }
}
