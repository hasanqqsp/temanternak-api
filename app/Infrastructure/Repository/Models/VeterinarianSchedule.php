<?php

namespace App\Infrastructure\Repository\Models;

use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Eloquent\SoftDeletes;

class VeterinarianSchedule extends Model
{
    use SoftDeletes;
    public function veterinarian()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }
}
