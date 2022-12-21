<?php

declare(strict_types=1);

namespace App\Messaging\Domain\Entity;

use App\Backoffice\User\Application\DTO\UserDTO;
use App\Backoffice\User\Domain\ValueObject\UserId;
use App\Messaging\Domain\Exception\ConversationAlreadyArchivedByParticipant;
use App\Messaging\Domain\ValueObject\ParticipantId;
use App\Messaging\Domain\ValueObject\ParticipantName;

class Participant
{
    private ParticipantId $id;

    private ParticipantName $name;

    private UserId $userId;

    private bool $isArchived;

    private function __construct(
        readonly UserDTO $user,
        private readonly Conversation $conversation,
    ) {
        $this->id = ParticipantId::generate();
        $this->userId = UserId::fromString($this->user->id);
        $this->name = ParticipantName::fromUserDTO($this->user);
        $this->isArchived = false;
    }

    public static function create(
        UserDTO $userDTO,
        Conversation $conversation,
    ): self {
        return new self($userDTO, $conversation);
    }

    /*
     * ===============================
     * == Actions
     * ===============================
     */

    /**
     * @throws ConversationAlreadyArchivedByParticipant
     */
    public function archive(): void
    {
        $this->ensureIsNotArchived();

        $this->isArchived = true;
    }

    /*
     * ===============================
     * == Getters
     * ===============================
     */

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

    /*
     * ===============================
     * == Validators
     * ===============================
     */

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
