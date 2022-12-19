<?php

declare(strict_types=1);

namespace App\Common\Domain\ValueObject;

abstract class StringValue
{
    protected function __construct(protected string $value)
    {
    }

    public static function fromString(string $value): static
    {
        return new static($value);
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value();
    }

    public function isEqual(self $other): bool
    {
        return (string) $this === (string) $other;
    }
}
