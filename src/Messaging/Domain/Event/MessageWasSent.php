<?php

declare(strict_types=1);

namespace App\Messaging\Domain\Event;

use App\Common\Domain\Event\DomainEvent;

final class MessageWasSent extends DomainEvent
{
    public const EVENT_NAME = 'messaging.message.sent';

    public static function eventName(): string
    {
        return self::EVENT_NAME;
    }
}
