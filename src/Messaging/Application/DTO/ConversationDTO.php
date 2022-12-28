<?php

declare(strict_types=1);

namespace App\Messaging\Application\DTO;

use App\Messaging\Domain\Entity\Conversation;
use App\Messaging\Domain\Entity\Participant;

final class ConversationDTO
{
    private function __construct(
        public readonly string $id,
        public readonly array $participants,
    ) {
    }

    public static function fromEntity(
        Conversation $conversation,
    ): ConversationDTO {
        $participantsDTOs = self::mapParticipantsToParticipantsDTOs($conversation->participants());

        return new self(
            id: (string) $conversation->id(),
            participants: $participantsDTOs,
        );
    }

    /**
     * @param Participant[] $participants
     * @return ParticipantDTO[]
     */
    private static function mapParticipantsToParticipantsDTOs(array $participants): array
    {
        return array_map(static function (Participant $participant) {
            return ParticipantDTO::fromEntity($participant);
        }, $participants);
    }
}
