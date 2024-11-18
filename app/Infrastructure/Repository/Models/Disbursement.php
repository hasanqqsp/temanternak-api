<?php

namespace App\Infrastructure\Repository\Models;

use App\Infrastructure\Repository\Models\Veterinarian;
use MongoDB\Laravel\Eloquent\Model;

class Disbursement extends Model
{
    public function veterinarian()
    {
        return $this->hasOne(User::class, 'id', 'veterinarian_id');
    }
}
