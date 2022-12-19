<?php

declare(strict_types=1);

namespace App\Messaging\Application\UseCase\CreateConversation;

use App\Backoffice\Users\Application\UseCase\GetUserById\GetUserByIdQuery;
use App\Backoffice\Users\Domain\ValueObject\UserId;
use App\Common\Application\Command\CommandHandler;
use App\Common\Application\Query\QueryBus;
use App\Common\Domain\ValueObject\DateTime;
use App\Messaging\Domain\Entity\Conversation;
use App\Messaging\Domain\Repository\ConversationRepository;

final class CreateConversationCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly ConversationRepository $conversationRepository,
        private readonly QueryBus $queryBus,
    ) {
    }

    public function __invoke(CreateConversationCommand $command): Conversation
    {
        // Load users collection from usersIds given by command
        $users = array_map(function (string $userId) {
            return $this->queryBus->ask(new GetUserByIdQuery(UserId::fromString($userId)));
        }, $command->members());

        $conversation = Conversation::create(DateTime::now(), $users);
        $this->conversationRepository->add($conversation);

        return $conversation;
    }
}
