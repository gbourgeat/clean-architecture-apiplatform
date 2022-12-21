<?php

declare(strict_types=1);

namespace App\Messaging\Application\DTO;

use App\Messaging\Domain\Entity\Conversation;

final class ConversationDTO
{
    private function __construct(
        public readonly string $id,
    ) {
    }

    public static function fromEntity(
        Conversation $conversation,
    ): ConversationDTO {
        return new self(
            id: (string) $conversation->id(),
        );
    }
}
