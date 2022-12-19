<?php

declare(strict_types=1);

namespace App\Messaging\Domain\Entity;

use App\Backoffice\Users\Domain\Entity\User;
use App\Backoffice\Users\Domain\ValueObject\UserId;
use App\Common\Domain\ValueObject\Email;
use App\Common\Domain\ValueObject\FirstName;
use App\Common\Domain\ValueObject\LastName;
use App\Messaging\Domain\Exception\ConversationAlreadyArchivedByParticipant;
use App\Messaging\Domain\ValueObject\ParticipantId;

class Participant
{
    private ParticipantId $id;
    private User $user;

    private Conversation $conversation;
    private bool $isArchived;

    private function __construct(
        User $user,
        Conversation $conversation,
    ) {
        $this->id = ParticipantId::generate();
        $this->user = $user;
        $this->conversation = $conversation;
        $this->isArchived = false;
    }

    public static function create(
        User $user,
        Conversation $conversation,
    ): self {
        return new self($user, $conversation);
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
        return $this->user->id();
    }

    public function firstName(): FirstName
    {
        return $this->user->firstName();
    }

    public function lastName(): LastName
    {
        return $this->user->lastName();
    }

    public function email(): Email
    {
        return $this->user->email();
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
