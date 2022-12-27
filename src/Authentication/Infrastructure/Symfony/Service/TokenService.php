<?php

declare(strict_types=1);

namespace App\Authentication\Infrastructure\Symfony\Service;

use App\Authentication\Application\Service\TokenDecoder;
use App\Authentication\Application\Service\TokenEncoder;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

final class TokenService implements TokenDecoder, TokenEncoder
{
    private const JWT_ALGORITHM = 'RS256';

    public function __construct(
        private readonly string $jwtPrivateKey,
        private readonly string $jwtPublicKey,
    ) {
    }

    public function decode(string $token): array
    {
        return (array) JWT::decode($token, new Key($this->getPublicKey(), self::JWT_ALGORITHM));
    }

    private function getPublicKey(): \OpenSSLAsymmetricKey
    {
        return openssl_pkey_get_public('file://' . $this->jwtPublicKey);
    }

    public function encode(array $payload): string
    {
        return JWT::encode($payload, $this->getPrivateKey(), self::JWT_ALGORITHM);
    }

    private function getPrivateKey(): \OpenSSLAsymmetricKey
    {
        return openssl_pkey_get_private('file://' . $this->jwtPrivateKey);
    }
}
