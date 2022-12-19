<?php

declare(strict_types=1);

namespace App\Messaging\Domain\DomainEvent;

use App\Common\Domain\Event\DomainEvent;

class MessageWasSent extends DomainEvent
{
    public function __construct(
        string $id,
        string $eventId,
        string $occurredOn,
        private readonly string $content,
        private readonly string $senderId,
    ) {
        parent::__construct($id, $eventId, $occurredOn);
    }

    public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredOn
    ): DomainEvent {
        return new self(
            $aggregateId,
            $eventId,
            $occurredOn,
            $body['content'],
            $body['senderId'],
        );
    }

    public static function eventName(): string
    {
        return 'messaging_channel.message_sent';
    }

    public function toPrimitives(): array
    {
        return [
            'content' => $this->content,
            'senderId' => $this->senderId,
        ];
    }
}
