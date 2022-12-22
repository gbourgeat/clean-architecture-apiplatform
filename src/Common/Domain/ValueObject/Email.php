<?php

declare(strict_types=1);

namespace App\Common\Domain\ValueObject;

use App\Common\Domain\Exception\InvalidFormat;

final class Email extends StringValue
{
    /**
     * @throws InvalidFormat
     */
    private function __construct(protected string $value)
    {
        $this->ensureIsValidEmail($value);

        parent::__construct($this->value);
    }

    /**
     * @throws InvalidFormat
     */
    public static function fromString(string $value): static
    {
        return new static($value);
    }

    /**
     * @throws InvalidFormat
     */
    private function ensureIsValidEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidFormat(sprintf('The email "%s" is not valid.', $email));
        }
    }
}
