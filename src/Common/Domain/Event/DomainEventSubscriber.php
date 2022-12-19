<?php

declare(strict_types=1);

namespace App\Common\Domain\Event;

interface DomainEventSubscriber
{
    public static function subscribedTo(): array;
}
