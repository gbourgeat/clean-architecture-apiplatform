<?php

declare(strict_types=1);

namespace App\Authentication\Application\DTO;

final class AuthTokenDTO implements \Stringable
{
    private function __construct(
        public readonly string $token,
    ) {
    }

    public static function fromString(string $token): AuthTokenDTO
    {
        return new self(token: $token);
    }

    public function __toString(): string
    {
        return $this->token;
    }
}
