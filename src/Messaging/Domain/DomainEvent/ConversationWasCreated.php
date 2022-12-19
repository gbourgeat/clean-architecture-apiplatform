<?php

declare(strict_types=1);

namespace App\Messaging\Domain\DomainEvent;

use App\Common\Domain\Event\DomainEvent;

class ConversationWasCreated extends DomainEvent
{
    public function __construct(
        string $id,
        string $eventId,
        string $occurredOn,
        private readonly string $creatorId,
        private readonly array $subscribersIds,
    ) {
        parent::__construct($id, $eventId, $occurredOn);
    }

    public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredOn,
    ): DomainEvent {
        return new self(
            $aggregateId,
            $eventId,
            $occurredOn,
            $body['creatorId'],
            $body['subscribersIds']
        );
    }

    public static function eventName(): string
    {
        return 'messaging_channel.created';
    }

    public function toPrimitives(): array
    {
        return [
            'creatorId' => $this->creatorId,
            'subscribersIds' => $this->subscribersIds,
        ];
    }
}
