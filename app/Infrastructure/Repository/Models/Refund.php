<?php

namespace App\Infrastructure\Repository\Models;

use App\Domain\Veterinarians\Entities\Veterinarian;
use MongoDB\Laravel\Eloquent\Model;

class Refund extends Model
{
    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'id', 'transaction_id');
    }

    public function oldBooking()
    {
        return $this->belongsTo(ServiceBooking::class, 'id', 'old_booking_id');
    }

    public function newBooking()
    {
        return $this->belongsTo(ServiceBooking::class, 'id', 'new_booking_id');
    }
    public function newService()
    {
        return $this->belongsTo(VeterinarianService::class, 'id', 'new_service_id');
    }
}
