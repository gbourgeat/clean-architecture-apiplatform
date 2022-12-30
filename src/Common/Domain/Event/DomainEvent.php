<?php

declare(strict_types=1);

namespace App\Common\Domain\Event;

use App\Common\Domain\ValueObject\AggregateRootId;
use App\Common\Domain\ValueObject\DateTime;
use App\Common\Domain\ValueObject\EventId;

abstract class DomainEvent
{
    private function __construct(
        private readonly AggregateRootId $aggregateRootId,
        private readonly EventId $eventId,
        private readonly DateTime $occurredOn,
    ) {
    }

    public static function create(
        AggregateRootId $aggregateRootId,
    ): static
    {
        $eventId = EventId::generate();
        $occuredOn = DateTime::now();

        return new static(
            aggregateRootId: $aggregateRootId,
            eventId: $eventId,
            occurredOn: $occuredOn,
        );
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

    public static function fromPrimitives(
        string $aggregateRootId,
        string $eventId,
        string $occurredOn,
    ): static {
        return new static(
            aggregateRootId: AggregateRootId::fromString($aggregateRootId),
            eventId: EventId::fromString($eventId),
            occurredOn: DateTime::fromSerialized($occurredOn),
        );
    }

    abstract public static function eventName(): string;

    /**
     * @return array{aggregateRootId: string, eventId: string, occurredOn: string}
     */
    public function toPrimitives(): array
    {
        return [
            'aggregateRootId' => (string) $this->aggregateRootId(),
            'eventId' => (string) $this->eventId(),
            'occurredOn' => $this->occurredOn()->toAtomString(),
        ];
    }
}
