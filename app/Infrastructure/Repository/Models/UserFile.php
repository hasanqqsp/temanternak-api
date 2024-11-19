<?php

namespace App\Infrastructure\Repository\Models;

use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Eloquent\SoftDeletes;

class UserFile extends Model
{
    use SoftDeletes;
    protected $table = 'user_files';

    protected $fillable = [
        'user_id',
        'file_path',
        'file_type',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }
}
