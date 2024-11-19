<?php

namespace App\Infrastructure\Repository\Models;

use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Eloquent\SoftDeletes;

class Invitation extends Model
{
    use SoftDeletes;

    public function inviter()
    {
        return $this->hasOne(User::class, 'id', 'inviter_id')->withTrashed();
    }
}
