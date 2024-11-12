<?php

namespace App\Infrastructure\Repository\Models;

use App\Domain\Veterinarians\Entities\Veterinarian;
use MongoDB\Laravel\Eloquent\Model;

class ServiceBooking extends Model
{
    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'id', 'transaction_id');
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

    public function consultation()
    {
        return $this->hasOne(Consultation::class, 'booking_id', 'id');
    }

    public function settlement()
    {
        return $this->hasOne(Settlement::class, 'booking_id', 'id');
    }
}
