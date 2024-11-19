<?php

namespace App\Infrastructure\Repository\Models;

use MongoDB\Laravel\Eloquent\Model;

class VeterinarianVerification extends Model
{
    public function registrationsData()
    {
        return $this->belongsTo(VeterinarianRegistration::class)->withTrashed();
    }
    public function verificator()
    {
        return $this->hasOne(User::class, 'id', 'verificator_id')->withTrashed();
    }
}
