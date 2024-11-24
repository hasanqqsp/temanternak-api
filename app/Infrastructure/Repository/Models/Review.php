<?php

namespace App\Infrastructure\Repository\Models;

use MongoDB\Laravel\Eloquent\Model;

class Review extends Model
{
    // Define the table associated with the model
    protected $table = 'reviews';

    // Define the relationships
    public function booking()
    {
        return $this->belongsTo(ServiceBooking::class, "id", "booking_id");
    }

    public function veterinarian()
    {
        return $this->hasOneThrough(User::class, ServiceBooking::class, "id", "id", "booking_id", "user_id");
    }
}
