<?php

declare(strict_types=1);

namespace App\Messaging\Domain\Entity;

use App\Messaging\Domain\Exception\ConversationAlreadyArchivedByParticipant;
use App\Messaging\Domain\ValueObject\ParticipantId;
use App\Messaging\Domain\ValueObject\ParticipantName;
use App\User\Application\DTO\UserDTO;
use App\User\Domain\ValueObject\UserId;

class Participant
{
    private ParticipantId $id;
    private ParticipantName $name;
    private UserId $userId;
    private bool $isArchived;

    private function __construct(
        readonly UserDTO $userDTO,
        private readonly Conversation $conversation,
    ) {
        $this->id = ParticipantId::generate();
        $this->userId = UserId::fromString($this->userDTO->id);
        $this->name = ParticipantName::fromUserDTO($this->userDTO);
        $this->isArchived = false;
    }

    public static function create(
        UserDTO $userDTO,
        Conversation $conversation,
    ): self {
        return new self($userDTO, $conversation);
    }

    /**
     * @throws ConversationAlreadyArchivedByParticipant
     */
    public function archive(): void
    {
        $this->ensureIsNotArchived();

        $this->isArchived = true;
    }

    public function id(): ParticipantId
    {
        return $this->id;
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function name(): ParticipantName
    {
        return $this->name;
    }

    public function conversation(): Conversation
    {
        return $this->conversation;
    }

    public function isArchived(): bool
    {
        return $this->isArchived;
    }

    /**
     * @throws ConversationAlreadyArchivedByParticipant
     */
    private function ensureIsNotArchived(): void
    {
        if ($this->isArchived()) {
            throw new ConversationAlreadyArchivedByParticipant($this->conversation());
        }
    }
}
