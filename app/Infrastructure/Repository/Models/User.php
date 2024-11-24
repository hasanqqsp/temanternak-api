<?php

namespace App\Infrastructure\Repository\Models;

use Bavix\Wallet\Interfaces\Confirmable;
use HPWebdeveloper\LaravelPayPocket\Interfaces\WalletOperations;
use HPWebdeveloper\LaravelPayPocket\Traits\ManagesWallet;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

use MongoDB\Laravel\Eloquent\SoftDeletes;
use PDO;

class User extends AuthUser implements WalletOperations
{
    use HasFactory, CanResetPassword, HasApiTokens, SoftDeletes, ManagesWallet;

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
            return $this->hasMany(VeterinarianRegistration::class, 'user_id', 'id')->withTrashed();
        }
        return null;
    }

    public function data()
    {
        if ($this->role === 'veterinarian') {
            return $this->hasOne(Veterinarian::class, 'user_id', 'id')->withTrashed();
        }
        return null;
    }

    public function services()
    {
        if ($this->role === 'veterinarian') {
            return $this->hasMany(VeterinarianService::class, 'veterinarian_id', 'id')->withTrashed();
        }
        return null;
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, "customer_id", "id");
    }

    public function bookings()
    {
        return $this->hasMany(ServiceBooking::class, "veterinarian_id", "id");
    }


    public function reviews()
    {
        return $this->hasManyThrough(Review::class, ServiceBooking::class, 'veterinarian_id', 'booking_id', 'id', 'id');
    }
}
