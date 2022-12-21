<?php

declare(strict_types=1);

namespace App\Messaging\Application\UseCase\SendMessage;

use App\Backoffice\User\Domain\Repository\UserRepository;
use App\Common\Application\Command\CommandHandler;
use App\Messaging\Domain\Exception\UserIsNotParticipantOfConversation;
use App\Messaging\Domain\Repository\ConversationRepository;

final class SendMessageCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly ConversationRepository $conversationRepository,
        private readonly UserRepository $userRepository,
    ) {
    }

    public function __invoke(SendMessageCommand $command): void
    {
        $conversation = $this->conversationRepository->get($command->conversationId);
        $user = $this->userRepository->get($command->connectedUserId);

        $participant = $conversation->participantFromUser($user);
        if (null === $participant) {
            throw new UserIsNotParticipantOfConversation($user->id(), $conversation->id());
        }

        $conversation->postMessage($participant, $command->messageContent);
    }
}
