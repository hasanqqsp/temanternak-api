<?php

namespace App\Infrastructure\Repository\Models;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use MongoDB\Laravel\Auth\User as AuthUser;
use MongoDB\Laravel\Eloquent\SoftDeletes;

class User extends AuthUser
{

    use HasFactory, CanResetPassword, HasApiTokens, SoftDeletes;

    protected $connection = 'mongodb';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function veterinarianRegistration()
    {
        if ($this->role === 'invited-user' || $this->role === 'veterinarian') {
            return $this->hasMany(VeterinarianRegistration::class, 'user_id', '_id');
        }
        return null;
    }
}
