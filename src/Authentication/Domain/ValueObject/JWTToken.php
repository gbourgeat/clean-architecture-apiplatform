<?php

declare(strict_types=1);

namespace App\Authentication\Domain\ValueObject;

use App\Common\Domain\Exception\InvalidFormat;
use App\Common\Domain\ValueObject\StringValue;

final class JWTToken extends StringValue
{
    private const JWT_PATTERN = '/^([a-zA-Z0-9_=]+)\.([a-zA-Z0-9_=]+)\.([a-zA-Z0-9_\-+\/=]*)/';

    /**
     * @throws InvalidFormat
     */
    protected function __construct(
        string $token,
    ) {
        parent::__construct($token);

        $this->ensureIsJWTPattern();
    }

    /**
     * @throws InvalidFormat
     */
    private function ensureIsJWTPattern(): void
    {
        $token = $this->value;

        if (!preg_match(self::JWT_PATTERN, $token)) {
            throw new InvalidFormat('The token isn\'t JWT format');
        }
    }
}
