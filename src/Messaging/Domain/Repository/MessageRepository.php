<?php

declare(strict_types=1);

namespace App\Messaging\Domain\Repository;

use App\Messaging\Domain\Entity\Message;
use App\Messaging\Domain\ValueObject\ConversationId;
use App\Common\Domain\Repository\Repository;
use Doctrine\Common\Collections\Collection;

/**
 * @extends Repository<Message>
 */
interface MessageRepository extends Repository
{
    public function withConversationId(ConversationId $conversationId): Collection;
}
