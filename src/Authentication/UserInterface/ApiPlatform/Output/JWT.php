<?php

declare(strict_types=1);

namespace App\Authentication\UserInterface\ApiPlatform\Output;

use App\Authentication\Application\DTO\AuthTokenDTO;

final class JWT
{
    private function __construct(
        public readonly string $token,
    ) {
    }

    public static function fromAuthTokenDTO(AuthTokenDTO $authToken): JWT
    {
        return new self((string) $authToken);
    }
}
