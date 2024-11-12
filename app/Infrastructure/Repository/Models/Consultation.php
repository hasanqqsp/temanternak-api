<?php

namespace App\Infrastructure\Repository\Models;

use MongoDB\Laravel\Eloquent\Model;

class Consultation extends Model
{

    public function service()
    {
        return $this->hasOne(VeterinarianService::class, 'id', 'service_id');
    }
    public  function veterinarian()
    {
        return $this->hasOne(User::class, 'id', 'veterinarian_id');
    }
    public  function customer()
    {
        return $this->hasOne(User::class, 'id', 'customer_id');
    }
    public  function booking()
    {
        return $this->hasOne(ServiceBooking::class, 'id', 'booking_id');
    }
}
