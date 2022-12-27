<?php

declare(strict_types=1);

namespace App\Authentication\Domain\ValueObject;

use App\Common\Domain\Exception\InvalidFormat;
use App\Common\Domain\ValueObject\StringValue;

final class Username extends StringValue
{
    /**
     * @throws InvalidFormat
     */
    protected function __construct(
        string $username,
    ) {
        parent::__construct($username);

        $this->ensureIsEmail();
    }

    /**
     * @throws InvalidFormat
     */
    private function ensureIsEmail(): void
    {
        if (!$this->isEmail()) {
            throw new InvalidFormat('The username should be of email type');
        }
    }

    private function isEmail(): bool
    {
        return (bool) filter_var($this->value(), FILTER_VALIDATE_EMAIL);
    }
}
