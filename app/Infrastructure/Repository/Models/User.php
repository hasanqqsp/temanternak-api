<?php

namespace App\Infrastructure\Repository\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
namespace App\Infrastructure\Repository\Models;

use App\Domain\UserRepository;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;


use Laravel\Sanctum\HasApiTokens;
use MongoDB\Laravel\Auth\User as AuthUser;
use MongoDB\Laravel\Eloquent\Model;

class User extends AuthUser implements UserRepository
{
    use HasFactory, CanResetPassword, HasApiTokens;

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
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

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
}
