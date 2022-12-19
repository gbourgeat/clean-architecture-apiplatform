<?php

declare(strict_types=1);

namespace App\Common\Application\Command;

interface CommandBus
{
    public function dispatch(Command $command): mixed;
}
