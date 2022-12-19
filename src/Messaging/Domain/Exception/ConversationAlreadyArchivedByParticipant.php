<?php

declare(strict_types=1);

namespace App\Messaging\Domain\Exception;

use App\Messaging\Domain\Entity\Conversation;

final class ConversationAlreadyArchivedByParticipant extends \DomainException
{
    public function __construct(Conversation $conversation)
    {
        parent::__construct(sprintf('The conversation "%s" was already archived.', (string) $conversation->id()));
    }
}
