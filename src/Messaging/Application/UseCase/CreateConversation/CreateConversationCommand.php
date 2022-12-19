<?php

declare(strict_types=1);

namespace App\Messaging\Application\UseCase\CreateConversation;

use App\Common\Application\Command\Command;

final class CreateConversationCommand implements Command
{
    public function __construct(
        private readonly array $members = [],
    ) {
    }

    public function members(): array
    {
        return $this->members;
    }
}
