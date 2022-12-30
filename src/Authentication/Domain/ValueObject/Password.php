<?php

declare(strict_types=1);

namespace App\Authentication\Domain\ValueObject;

use App\Common\Domain\Exception\InvalidFormat;
use App\Common\Domain\ValueObject\StringValue;

final class Password extends StringValue
{
    private const MIN_LENGTH = 8;

    /**
     * @throws InvalidFormat
     */
    protected function __construct(
        string $password,
    ) {
        parent::__construct($password);

        $this->ensureIsStrength();
    }

    /**
     * @throws InvalidFormat
     */
    private function ensureIsStrength(): void
    {
        $password = $this->value;

        if (
            !$this->hasUppercaseChar($password)
            || !$this->hasLowercaseChar($password)
            || !$this->hasNumberChar($password)
            || !$this->hasSpecialChar($password)
            || !$this->hasValidLength($password)
        ) {
            throw new InvalidFormat('The password is not enough strength, should contain minimum 8 characters and should contain at least one uppercase, lowercase, number and special char');
        }
    }

    private function hasUppercaseChar(string $password): bool
    {
        return false !== preg_match('/[A-Z]/', $password);
    }

    private function hasLowercaseChar(string $password): bool
    {
        return false !== preg_match('/[a-z]/', $password);
    }

    private function hasNumberChar(string $password): bool
    {
        return false !== preg_match('/\d/', $password);
    }

    private function hasSpecialChar(string $password): bool
    {
        return false !== preg_match('/\W/', $password);
    }

    private function hasValidLength(string $password): bool
    {
        return strlen($password) >= self::MIN_LENGTH;
    }
}
