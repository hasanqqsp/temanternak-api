<?php

namespace App\Infrastructure\Repository\Models;

use MongoDB\Laravel\Eloquent\Model;

class ServiceBooking extends Model
{
    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'id', 'transaction_id');
    }

    public function service()
    {
        return $this->belongsTo(VeterinarianService::class)->withTrashed();
    }

    public function veterinarian()
    {
        return $this->belongsTo(User::class, 'veterinarian_id', 'id')->withTrashed();
    }

    public function booker()
    {
        return $this->belongsTo(User::class, 'booker_id', 'id')->withTrashed();
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
