<?php

namespace App\Infrastructure\Repository\Models;

use App\Domain\Veterinarians\Entities\Veterinarian;
use MongoDB\Laravel\Eloquent\Model;

class ServiceBooking extends Model
{
    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    public function service()
    {
        return $this->belongsTo(VeterinarianService::class);
    }

    public function veterinarian()
    {
        return $this->belongsTo(User::class, 'veterinarian_id', 'id');
    }

    public function booker()
    {
        return $this->belongsTo(User::class, 'booker_id', 'id');
    }
}
