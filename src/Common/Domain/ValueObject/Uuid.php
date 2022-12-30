<?php

declare(strict_types=1);

namespace App\Common\Domain\ValueObject;

use Ramsey\Uuid\Uuid as RamseyUuid;

abstract class Uuid
{
    private function __construct(protected string $value)
    {
        $this->ensureIsValidUuid($value);
    }

    public static function generate(): static
    {
        return new static(RamseyUuid::uuid4()->toString());
    }

    public static function fromString(string $value): static
    {
        return new static($value);
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(mixed $other): bool
    {
        return (string) $this === (string) $other;
    }

    public function __toString(): string
    {
        return $this->value();
    }

    private function ensureIsValidUuid(string $id): void
    {
        if (!RamseyUuid::isValid($id)) {
            throw new \InvalidArgumentException(sprintf('The uuid "%s" is not valid.', $id));
        }
    }
}
