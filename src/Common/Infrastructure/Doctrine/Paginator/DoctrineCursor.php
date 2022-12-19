<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Doctrine\Paginator;

use App\Common\Domain\Repository\Cursor;
use App\Common\Domain\Repository\CursorDirection;
use App\Common\Domain\ValueObject\DateTime;
use Doctrine\ORM\QueryBuilder;

class DoctrineCursor implements Cursor
{
    private function __construct(
        private readonly string $cursorValue,
        private readonly int $limit,
        private readonly string $cursorField,
        private readonly CursorDirection $cursorDirection,
    ) {
    }

    public static function create(
        string $cursorValue,
        int $limit,
        string $cursorField,
        CursorDirection $cursorDirection,
    ): self {
        return new self($cursorValue, $limit, $cursorField, $cursorDirection);
    }

    public static function fromToken(string $cursorToken): self
    {
        try {
            $b64Decoded = base64_decode($cursorToken);
            [$value, $limit, $field, $direction] = json_decode($b64Decoded, true, 512, JSON_THROW_ON_ERROR);
        } catch (\Exception $exception) {
            throw new \RuntimeException('Error occurred on parsing cursor token, it seems invalid.', 0, $exception);
        }

        return new self($value, $limit, $field, CursorDirection::tryFrom($direction));
    }

    /**
     * @throws \ReflectionException
     */
    public function applyOnQueryBuilder(QueryBuilder $queryBuilder, bool $reverse): void
    {
        $discriminatorProperty = new \ReflectionProperty($queryBuilder->getRootEntities()[0], $this->cursorField);

        $field = $queryBuilder->getRootAliases()[0].'.'.$this->cursorField;

        $where = !$reverse
            ? $queryBuilder->expr()->lte($field, ':cursorValue')
            : $queryBuilder->expr()->gte($field, ':cursorValue');

        $queryBuilder->andWhere($where);

        if (is_a(DateTime::class, $discriminatorProperty->getType()?->getName(), true)) {
            $queryBuilder->setParameter('cursorValue', DateTime::createFromTimestampMs($this->cursorValue / 1000));
        } else {
            $queryBuilder->setParameter('cursorValue', $this->cursorValue);
        }
    }

    public function jsonSerialize(): array
    {
        return [
            $this->cursorValue,
            $this->limit,
            $this->cursorField,
            $this->cursorDirection,
        ];
    }

    /**
     * @throws \JsonException
     */
    public function __toString(): string
    {
        return base64_encode(json_encode([
            $this->cursorValue,
            $this->limit,
            $this->cursorField,
            $this->cursorDirection,
        ], JSON_THROW_ON_ERROR));
    }

    public function direction(): CursorDirection
    {
        return $this->cursorDirection;
    }

    public function createPrevFromValue(?string $value): ?self
    {
        if (null === $value) {
            return null;
        }

        return new self($value, $this->limit, $this->cursorField, CursorDirection::BEFORE);
    }

    public function createNextFromValue(?string $value): ?self
    {
        if (null === $value) {
            return null;
        }

        return new self($value, $this->limit, $this->cursorField, CursorDirection::AFTER);
    }
}
