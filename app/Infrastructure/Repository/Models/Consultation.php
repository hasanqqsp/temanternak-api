<?php

namespace App\Infrastructure\Repository\Models;

use MongoDB\Laravel\Eloquent\Model;

class Consultation extends Model
{

    public function service()
    {
        return $this->belongsTo(VeterinarianService::class, 'id', 'service_id');
    }
    public  function veterinarian()
    {
        return $this->belongsTo(User::class, 'id', 'veterinarian_id');
    }
    public  function customer()
    {
        return $this->belongsTo(User::class, 'id', 'customer_id');
    }
}
