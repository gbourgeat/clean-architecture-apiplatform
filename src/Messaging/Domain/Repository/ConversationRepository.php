<?php

declare(strict_types=1);

namespace App\Messaging\Domain\Repository;

use App\Messaging\Domain\Entity\Conversation;
use App\Messaging\Domain\Exception\ConversationNotFound;
use App\Messaging\Domain\ValueObject\ConversationId;
use App\Common\Domain\Repository\Repository;

/**
 * @extends Repository<Conversation>
 */
interface ConversationRepository extends Repository
{
    public function add(Conversation $conversation): void;

    public function remove(Conversation $conversation): void;

    /**
     * @throws ConversationNotFound
     */
    public function get(ConversationId $conversationId): Conversation;

    public function search(int $pageNumber, int $itemsPerPage): array;
}
