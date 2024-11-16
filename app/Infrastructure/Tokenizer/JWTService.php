<?php

namespace App\Infrastructure\Tokenizer;

use Carbon\Carbon;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTService
{

    private $secretKey;

    public function __construct()
    {
        $this->secretKey = env("JWT_SECRET");
    }

    public function generate(array $payload, Carbon $expirationTime, Carbon $issuedAt = null)
    {
        $expirationTime = $expirationTime->getTimestamp();
        $payload['iat'] = $issuedAt->getTimestamp() ?? now()->getTimestamp();
        $payload['exp'] = $expirationTime;

        return JWT::encode($payload, $this->secretKey, 'HS256');
    }

    public function verify($token)
    {
        try {
            $decoded = JWT::decode($token, new Key($this->secretKey, 'HS256'));
            return (array) $decoded;
        } catch (\Exception $e) {
            return false;
        }
    }
}
