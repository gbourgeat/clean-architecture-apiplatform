<?php

declare(strict_types=1);

namespace App\Messaging\Domain\Exception;

use App\Messaging\Domain\ValueObject\ConversationId;
use App\User\Domain\ValueObject\UserId;

final class UserIsAlreadyParticipantOfConversation extends \DomainException
{
    public function __construct(UserId $userId, ConversationId $conversationId)
    {
        parent::__construct(sprintf('The user "%s" was already participant of conversation "%s".', (string) $userId, (string) $conversationId));
    }
}
