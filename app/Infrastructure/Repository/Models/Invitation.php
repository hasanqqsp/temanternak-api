<?php

namespace App\Infrastructure\Repository\Models;

use MongoDB\Laravel\Eloquent\Model;

class Invitation extends Model
{
    protected $table = 'invitations';

    protected $fillable = [
        'email',
        'name',
        'inviter_id',
        'message',
        'phone',
        'created_at',
        'updated_at',
        'is_revoked',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'is_revoked' => 'boolean'
    ];
}
