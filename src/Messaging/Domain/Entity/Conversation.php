<?php

declare(strict_types=1);

namespace App\Messaging\Domain\Entity;

use App\Authentication\Application\DTO\AuthUserDTO;
use App\Common\Domain\Entity\AggregateRoot;
use App\Common\Domain\ValueObject\DateTime;
use App\Messaging\Domain\Exception\NotEnoughParticipants;
use App\Messaging\Domain\Exception\ParticipantNotFoundInConversation;
use App\Messaging\Domain\Exception\UserIsNotParticipantOfConversation;
use App\Messaging\Domain\ValueObject\ConversationId;
use App\Messaging\Domain\ValueObject\MessageContent;
use App\User\Application\DTO\UserDTO;
use App\User\Domain\ValueObject\UserId;
use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Conversation extends AggregateRoot
{
    public const MIN_PARTICIPANTS = 2;

    private ConversationId $id;

    private DateTime $createdAt;

    /** @var Collection<int, Message> */
    private Collection $messages;

    /** @var Collection<int, Participant> */
    private Collection $participants;

    /**
     * @param UserDTO[] $usersDTOs
     */
    private function __construct(DateTime $createdAt, array $usersDTOs)
    {
        $this->ensureHasEnoughParticipants($usersDTOs);

        $this->id = ConversationId::generate();
        $this->createdAt = $createdAt;
        $this->messages = new ArrayCollection();
        $this->participants = new ArrayCollection();

        foreach ($usersDTOs as $userDTO) {
            $this->addParticipant(Participant::create($userDTO, $this));
        }
    }

    /**
     * @param UserDTO[] $usersDTOs
     */
    public static function create(DateTime $createdAt, array $usersDTOs): self
    {
        return new self(
            createdAt: $createdAt,
            usersDTOs: $usersDTOs,
        );
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

    public function createdAt(): DateTime
    {
        return $this->createdAt;
    }

    public function participants(): array
    {
        return $this->participants->toArray();
    }

    public function participantFromAuthUser(AuthUserDTO $authUser): Participant
    {
        foreach ($this->participants as $participant) {
            if ($participant->userId()->equals($authUser->userId)) {
                return $participant;
            }
        }

        throw new UserIsNotParticipantOfConversation(
            userId: UserId::fromString($authUser->userId),
            conversationId: $this->id(),
        );
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
