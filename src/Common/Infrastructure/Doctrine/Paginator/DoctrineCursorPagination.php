<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Doctrine\Paginator;

use App\Common\Domain\Repository\CursorDirection;
use App\Common\Domain\Repository\CursorPagination;
use App\Common\Domain\ValueObject\DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query\Expr\OrderBy;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

final class DoctrineCursorPagination implements CursorPagination
{
    private ?Collection $items = null;

    private ?DoctrineCursor $parsedCursor = null;

    private ?DoctrineCursor $nextCursor = null;

    private ?DoctrineCursor $prevCursor = null;

    private PropertyAccessor $propertyAccessor;

    private string $fullFieldNameQuery;

    /**
     * @throws \Exception
     */
    public function __construct(
        private readonly QueryBuilder $queryBuilder,
        private readonly int $limit,
        private readonly string $field,
        private readonly string $direction,
        ?string $cursor,
    ) {
        if (null !== $cursor) {
            $this->parsedCursor = DoctrineCursor::fromToken($cursor);
        }

        $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
        $this->fullFieldNameQuery = $this->queryBuilder->getRootAliases()[0].'.'.$this->field;
    }

    public function getIterator(): \IteratorAggregate
    {
        if (null === $this->items) {
            $reverse = CursorDirection::BEFORE === $this->parsedCursor?->direction();

            $direction = $this->direction;
            if ($reverse) {
                $direction = ('ASC' === $direction) ? 'DESC' : 'ASC';
            }

            $mainQueryBuilder = clone $this->queryBuilder;
            $this->parsedCursor?->applyOnQueryBuilder($mainQueryBuilder, $reverse);

            /** @var array $result */
            $result = $mainQueryBuilder
                ->orderBy(new OrderBy($this->fullFieldNameQuery, $direction))
                ->setMaxResults($this->limit)
                ->getQuery()
                ->getResult();

            if ($reverse) {
                $result = array_reverse($result);
            }
            $this->items = new ArrayCollection($result);

            if (!$this->items->count()) {
                return $this->items;
            }

            $this->loadNextCursorFromLastResultItem((object) $this->items->last());
            $this->loadPrevCursorFromFirstResultItem((object) $this->items->first());
        }

        return $this->items;
    }

    public function nextCursor(): ?DoctrineCursor
    {
        return $this->nextCursor;
    }

    public function prevCursor(): ?DoctrineCursor
    {
        return $this->prevCursor;
    }

    private function loadNextCursorFromLastResultItem(object $lastResultItem): void
    {
        $nextResultQueryBuilder = clone $this->queryBuilder;
        $lastValue = $this->getDiscriminatorValue($lastResultItem);

        try {
            /** @var ?object $nextResult */
            $nextResult = $nextResultQueryBuilder
                ->andWhere($this->fullFieldNameQuery.' < :lastValue')
                ->setParameter('lastValue', DateTime::createFromTimestampMs((int) $lastValue / 1000))
                ->setMaxResults(1)
                ->orderBy(new OrderBy($this->fullFieldNameQuery, $this->direction))
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException) {
            throw new \InvalidArgumentException('The cursor discriminator field must be unique.');
        }

        if (null === $nextResult) {
            return;
        }

        $this->nextCursor = DoctrineCursor::create(
            $this->getDiscriminatorValue($nextResult),
            $this->limit,
            $this->field,
            CursorDirection::AFTER
        );
    }

    private function loadPrevCursorFromFirstResultItem(object $firstResultItem): void
    {
        $previousResultQueryBuilder = clone $this->queryBuilder;
        $firstValue = $this->getDiscriminatorValue($firstResultItem);

        $direction = ('ASC' === $this->direction) ? 'DESC' : 'ASC';

        try {
            /** @var ?object $previousResult */
            $previousResult = $previousResultQueryBuilder
                ->andWhere($this->fullFieldNameQuery.' > :firstValue')
                ->setParameter('firstValue', DateTime::createFromTimestampMs((int) $firstValue / 1000))
                ->setMaxResults(1)
                ->orderBy(new OrderBy($this->fullFieldNameQuery, $direction))
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException) {
            throw new \InvalidArgumentException('The cursor discriminator field must be unique.');
        }

        if (null === $previousResult) {
            return;
        }

        $this->prevCursor = DoctrineCursor::create(
            $this->getDiscriminatorValue($previousResult),
            $this->limit,
            $this->field,
            CursorDirection::BEFORE
        );
    }

    private function getDiscriminatorValue(object $boundaryItem): string
    {
        /** @var DateTime|string|int|float $lastValue */
        $lastValue = $this->propertyAccessor->getValue($boundaryItem, $this->field);
        if ($lastValue instanceof DateTime) {
            $lastValue = $lastValue->format('Uu');
        }

        return (string) $lastValue;
    }
}
