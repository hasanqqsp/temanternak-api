<?php

namespace App\Infrastructure\Repository\Models;

use MongoDB\Laravel\Eloquent\Model;

class Transaction extends Model
{
    public function serviceBooking()
    {
        return $this->belongsTo(ServiceBooking::class);
    }
}
