<?php

declare(strict_types=1);

namespace App\Messaging\Application\DTO;

use App\Messaging\Domain\Entity\Message;

final class MessageDTO
{
    private function __construct(
        public readonly string $id,
        public readonly string $content,
        public readonly ParticipantDTO $author,
    ) {
    }

    public static function fromEntity(Message $message): MessageDTO
    {
        return new self(
            id: (string) $message->id(),
            content: (string) $message->content(),
            author: ParticipantDTO::fromEntity($message->sentBy()),
        );
    }
}
