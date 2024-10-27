<?php

namespace App\Infrastructure\Hasher;

use App\Services\Hash\HashingServiceInterface;
use Illuminate\Support\Facades\Hash;

class BcryptHasher implements HashingServiceInterface
{

    public function make($value): string
    {
        return Hash::make($value);
    }

    public function check($value, $hashedValue): bool
    {
        return Hash::check($value, $hashedValue);
    }

    public function needRehash($hashedValue): bool
    {
        return Hash::needsRehash($hashedValue);
    }
}
