<?php

namespace App\Infrastructure\Repository\Models;

use MongoDB\Laravel\Eloquent\Model;

class Settlement extends Model
{
    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'id', 'transaction_id');
    }
    public function veterinarian()
    {
        return $this->hasOne(User::class, 'id', 'veterinarian_id');
    }
    public function service()
    {
        return $this->hasOne(VeterinarianService::class, 'id', 'service_id');
    }
    public function booking()
    {
        return $this->hasOne(ServiceBooking::class, 'id', 'booking_id');
    }
}
