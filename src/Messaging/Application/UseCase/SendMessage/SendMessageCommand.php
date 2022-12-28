<?php

declare(strict_types=1);

namespace App\Messaging\Application\UseCase\SendMessage;

use App\Common\Application\Command\Command;

final class SendMessageCommand implements Command
{
    public function __construct(
        public readonly string $conversationId,
        public readonly string $messageContent,
    ) {
    }
}
