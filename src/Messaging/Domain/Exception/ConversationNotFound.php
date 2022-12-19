<?php

declare(strict_types=1);

namespace App\Messaging\Domain\Exception;

use App\Messaging\Domain\ValueObject\ConversationId;

final class ConversationNotFound extends \DomainException
{
    public function __construct(ConversationId $conversationId)
    {
        parent::__construct(sprintf('The conversation was not found for id "%s".', (string) $conversationId));
    }
}
