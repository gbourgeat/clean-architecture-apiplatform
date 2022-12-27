<?php

declare(strict_types=1);

namespace App\Authentication\Domain\ValueObject;

use App\Common\Domain\Exception\InvalidFormat;
use App\Common\Domain\ValueObject\StringValue;

final class HashedPassword extends StringValue
{
    private const BCRYPT_PATTERN = '/^\$2[ayb]\$.{56}$/';

    /**
     * @throws InvalidFormat
     */
    protected function __construct(
        string $hashedPassword,
    ) {
        parent::__construct($hashedPassword);

        $this->ensureIsBcryptPattern();
    }

    /**
     * @throws InvalidFormat
     */
    private function ensureIsBcryptPattern(): void
    {
        $hashedPassword = $this->value;

        if (!preg_match(self::BCRYPT_PATTERN, $hashedPassword)) {
            throw new InvalidFormat('The hashed password isn\'t bcrypt encoded format');
        }
    }
}
