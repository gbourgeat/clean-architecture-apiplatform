<?php

declare(strict_types=1);

namespace App\Messaging\Application\UseCase\SendMessage;

use App\Backoffice\Users\Domain\ValueObject\UserId;
use App\Common\Application\Command\Command;
use App\Messaging\Domain\ValueObject\ConversationId;
use App\Messaging\Domain\ValueObject\MessageContent;

final class SendMessageCommand implements Command
{
    public function __construct(
        public readonly UserId $connectedUserId,
        public readonly ConversationId $conversationId,
        public readonly MessageContent $messageContent,
    ) {
    }
}
