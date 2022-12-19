<?php

declare(strict_types=1);

namespace App\Messaging\Domain\Exception;

use App\Messaging\Domain\ValueObject\ConversationId;
use App\Messaging\Domain\ValueObject\ParticipantId;

final class ParticipantNotFoundInConversation extends \DomainException
{
    public function __construct(ConversationId $conversationId, ParticipantId $participantId)
    {
        parent::__construct(sprintf('The participant with id "%s" is not found in conversation "%s".', (string) $participantId, (string) $conversationId));
    }
}
