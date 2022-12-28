<?php

declare(strict_types=1);

namespace App\Messaging\Domain\Entity;

use App\Backoffice\User\Application\DTO\UserDTO;
use App\Backoffice\User\Domain\Entity\User;
use App\Common\Domain\Entity\AggregateRoot;
use App\Messaging\Domain\Exception\NotEnoughParticipants;
use App\Messaging\Domain\Exception\ParticipantNotFoundInConversation;
use App\Messaging\Domain\ValueObject\ConversationId;
use App\Messaging\Domain\ValueObject\MessageContent;
use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Conversation extends AggregateRoot
{
    public const MIN_PARTICIPANTS = 2;

    /**
     * Identifier.
     */
    private ConversationId $id;

    /**
     * Date of creating.
     */
    private Carbon $createdAt;

    /**
     * Messages.
     *
     * @var Collection<int, Message>
     */
    private Collection $messages;

    /**
     * Participants.
     *
     * @var Collection<int, Participant>
     */
    private Collection $participants;

    /**
     * @param UserDTO[] $users
     */
    private function __construct(Carbon $createdAt, array $users)
    {
        $this->ensureHasEnoughParticipants($users);

        $this->id = ConversationId::generate();
        $this->createdAt = $createdAt;
        $this->messages = new ArrayCollection();
        $this->participants = new ArrayCollection();

        foreach ($users as $user) {
            $this->participants->add(Participant::create($user, $this));
        }
    }

    /**
     * @param UserDTO[] $users
     */
    public static function create(Carbon $createdAt, array $users): self
    {
        return new self($createdAt, $users);
    }

    public function postMessage(Participant $participant, MessageContent $content): void
    {
        $this->ensureParticipantIsInConversation($participant);

        $this->messages
            ->add(
                Message::create(
                    $this,
                    $content,
                    Carbon::now(),
                    $participant,
                )
            );

        // TODO Put here the event about message sent
    }

    public function addParticipant(Participant $participant): void
    {
        $this->participants->add($participant);
    }

    public function archiveForParticipant(Participant $participant): void
    {
        $this->ensureParticipantIsInConversation($participant);

        $participant->archive();
    }

    public function id(): ConversationId
    {
        return $this->id;
    }

    public function createdAt(): Carbon
    {
        return $this->createdAt;
    }

    public function participants(): array
    {
        return $this->participants->toArray();
    }

    /**
     * Return the participant of conversation which correspond to user given.
     */
    public function participantFromUser(User $user): ?Participant
    {
        foreach ($this->participants as $participant) {
            if ($participant->user()->id()->equals($user->id())) {
                return $participant;
            }
        }

        return null;
    }

    private function ensureParticipantIsInConversation(Participant $participant): void
    {
        if (!$participant->conversation()->id()->equals($this->id())) {
            throw new ParticipantNotFoundInConversation($this->id(), $participant->id());
        }
    }

    private function ensureHasEnoughParticipants(array $users): void
    {
        if (count($users) < self::MIN_PARTICIPANTS) {
            throw new NotEnoughParticipants(self::MIN_PARTICIPANTS, count($users));
        }
    }
}
