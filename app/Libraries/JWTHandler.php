<?php

namespace App\Libraries;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Config\JWT as JWTConfig;

class JWTHandler
{
    protected $config;

    public function __construct()
    {
        $this->config = config(JWTConfig::class);
    }

    public function generateToken(array $payload): string
    {
        $issuedAt = time();
        $expiry = $issuedAt + $this->config->expiry;

        $payload['iat'] = $issuedAt;
        $payload['exp'] = $expiry;

        return JWT::encode($payload, $this->config->key, $this->config->algo);
    }

    public function validateToken(string $token): object|bool
    {
        try {
            return JWT::decode($token, new Key($this->config->key, $this->config->algo));
        } catch (\Exception $e) {
            return false;
        }
    }
}
