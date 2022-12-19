<?php

declare(strict_types=1);

namespace App\Common\Domain\ValueObject;

final class Email extends StringValue
{
    private function __construct(protected string $value)
    {
        parent::__construct($this->value);

        $this->ensureIsValidEmail($this->value);
    }

    public static function fromString(string $value): static
    {
        return new self($value);
    }

    private function ensureIsValidEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException(sprintf('The email "%s" is not valid.', $email));
        }
    }
}
