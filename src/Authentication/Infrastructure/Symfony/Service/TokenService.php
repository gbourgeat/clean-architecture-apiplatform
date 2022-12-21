<?php

declare(strict_types=1);

namespace App\Authentication\Infrastructure\Symfony\Service;

use App\Authentication\Application\DTO\AuthTokenDTO;
use App\Authentication\Application\DTO\AuthUserDTO;
use App\Authentication\Application\Service\TokenDecoder;
use App\Authentication\Application\Service\TokenEncoder;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

final class TokenService implements TokenDecoder, TokenEncoder
{
    public function decode(AuthTokenDTO $token): AuthUserDTO
    {
        $jwtPayload = (array) JWT::decode((string) $token, new Key('example_key', 'HS256'));

        return AuthUserDTO::createFromJWTPayload($jwtPayload);
    }

    public function encode(AuthUserDTO $authUserDTO): AuthTokenDTO
    {
        $jwtToken = JWT::encode([
            'userId' => $authUserDTO->userId,
            'email' => $authUserDTO->email,
            'firstName' => $authUserDTO->firstName,
            'lastName' => $authUserDTO->lastName,
        ], 'example_key', 'HS256');

        return AuthTokenDTO::fromString($jwtToken);
    }
}
