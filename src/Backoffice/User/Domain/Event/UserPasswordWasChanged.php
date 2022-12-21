<?php

declare(strict_types=1);

namespace App\Backoffice\User\Domain\Event;

use App\Common\Domain\Event\DomainEvent;
use App\Common\Domain\ValueObject\AggregateRootId;
use App\Common\Domain\ValueObject\DateTime;
use App\Common\Domain\ValueObject\EventId;

final class UserPasswordWasChanged extends DomainEvent
{
    private const EVENT_NAME = 'users.password_was_changed';

    public static function fromPrimitives(
        string $aggregateRootId,
        array $body,
        string $eventId,
        string $occurredOn,
    ): DomainEvent {
        return new self(
            AggregateRootId::fromString($aggregateRootId),
            EventId::fromString($eventId),
            $body,
            DateTime::fromSerialized($occurredOn),
        );
    }

    public static function eventName(): string
    {
        return self::EVENT_NAME;
    }

    public function toPrimitives(): array
    {
        return [

        ];
    }
}
