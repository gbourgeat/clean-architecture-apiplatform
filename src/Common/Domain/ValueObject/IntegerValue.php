<?php

declare(strict_types=1);

namespace App\Common\Domain\ValueObject;

abstract class IntegerValue
{
    private function __construct(protected IntegerValue $value)
    {
    }

    public static function fromInt(IntegerValue $value): static
    {
        return new static($value);
    }

    public function value(): static
    {
        return $this->value;
    }

    public function isEqual(self $other): bool
    {
        return $this->value() === $other->value();
    }

    public function isLowerThan(self $other): bool
    {
        return $this->value() < $other->value();
    }

    public function isBiggerThan(self $other): bool
    {
        return $this->value() > $other->value();
    }
}
