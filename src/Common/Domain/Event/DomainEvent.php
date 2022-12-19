<?php

declare(strict_types=1);

namespace App\Common\Domain\Event;

use App\Common\Domain\ValueObject\AggregateRootId;
use App\Common\Domain\ValueObject\DateTime;
use App\Common\Domain\ValueObject\EventId;

abstract class DomainEvent
{

    public function __construct(
        private readonly AggregateRootId $aggregateRootId,
        private readonly EventId $eventId,
        private readonly array $body,
        private readonly DateTime $occurredOn,
    ) {
    }

    public function aggregateRootId(): AggregateRootId
    {
        return $this->aggregateRootId;
    }

    public function eventId(): EventId
    {
        return $this->eventId;
    }

    public function occurredOn(): DateTime
    {
        return $this->occurredOn;
    }

    abstract public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredOn,
    ): self;

    abstract public static function eventName(): string;

    abstract public function toPrimitives(): array;
}
