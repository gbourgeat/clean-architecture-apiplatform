<?php

declare(strict_types=1);

namespace App\Common\Domain\Event;

interface EventBus
{
    public function publish(DomainEvent ...$events): void;
}
