<?php

namespace App\Infrastructure\Repository\Models;

use MongoDB\Laravel\Eloquent\Model;

class Transaction extends Model
{
    public function serviceBooking()
    {
        return $this->belongsTo(ServiceBooking::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id', 'id')->withTrashed();
    }
}
