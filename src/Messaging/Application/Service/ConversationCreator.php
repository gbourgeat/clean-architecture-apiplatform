<?php

declare(strict_types=1);

namespace App\Messaging\Application\Service;

use App\Common\Application\Query\QueryBus;
use App\Common\Domain\ValueObject\DateTime;
use App\Messaging\Domain\Entity\Conversation;
use App\Messaging\Domain\Repository\ConversationRepository;
use App\User\Application\DTO\UserDTO;
use App\User\Application\UseCase\GetUserById\GetUserByIdQuery;

final class ConversationCreator
{
    public function __construct(
        private readonly ConversationRepository $conversationRepository,
        private readonly QueryBus $queryBus,
    ) {
    }

    public function createConversation(array $usersIds): Conversation
    {
        $usersDTOs = $this->getUsersDTOsFromUsersIds($usersIds);

        $conversation = Conversation::create(DateTime::now(), $usersDTOs);

        $this->conversationRepository->add($conversation);

        return $conversation;
    }

    /**
     * @param int[] $usersIds
     * @return UserDTO[]
     */
    private function getUsersDTOsFromUsersIds(array $usersIds): array
    {
        /** @var UserDTO[] $users */
        return array_map(function (string $userId) {
            return $this->queryBus->ask(new GetUserByIdQuery(userId: $userId));
        }, $usersIds);
    }
}
