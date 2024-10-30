<?php

namespace App\Infrastructure\Repository\Models;

use MongoDB\Laravel\Eloquent\Model;

class VeterinarianRegistration extends Model
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
    public function invitation()
    {
        return $this->hasOne(Invitation::class, 'id', 'invitation_id');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
