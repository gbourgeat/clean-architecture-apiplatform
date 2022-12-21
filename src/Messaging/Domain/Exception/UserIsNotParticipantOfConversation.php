<?php

declare(strict_types=1);

namespace App\Messaging\Domain\Exception;

use App\Backoffice\User\Domain\ValueObject\UserId;
use App\Messaging\Domain\ValueObject\ConversationId;

final class UserIsNotParticipantOfConversation extends \DomainException
{
    public function __construct(UserId $userId, ConversationId $conversationId)
    {
        parent::__construct(sprintf('The user "%s" are not a participant of conversation "%s".', (string) $userId, (string) $conversationId));
    }
}
