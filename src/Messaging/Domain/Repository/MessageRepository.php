<?php

declare(strict_types=1);

namespace App\Messaging\Domain\Repository;

use App\Messaging\Domain\Entity\Message;
use App\Messaging\Domain\ValueObject\ConversationId;
use App\Common\Domain\Repository\Repository;

/**
 * @extends Repository<Message>
 */
interface MessageRepository extends Repository
{
    public function searchByConversationId(ConversationId $conversationId, int $page, int $itemsPerPage): array;
}
