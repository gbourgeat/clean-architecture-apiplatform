<?php

declare(strict_types=1);

namespace App\Messaging\Infrastructure\Doctrine\Repository;

use App\Common\Domain\Repository\CursorPagination;
use App\Common\Infrastructure\Doctrine\Paginator\DoctrineCursorPagination;
use App\Messaging\Domain\Entity\Conversation;
use App\Messaging\Domain\Exception\ConversationNotFound;
use App\Messaging\Domain\Repository\ConversationRepository;
use App\Messaging\Domain\ValueObject\ConversationId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineConversationRepository extends ServiceEntityRepository implements ConversationRepository
{
    public const ALIAS = 'conversation';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Conversation::class);
    }

    public function add(Conversation $conversation): void
    {
        $this->getEntityManager()->persist($conversation);
        $this->getEntityManager()->flush();
    }

    public function remove(Conversation $conversation): void
    {
        $this->getEntityManager()->remove($conversation);
        $this->getEntityManager()->flush();
    }

    /**
     * @throws ConversationNotFound
     */
    public function get(ConversationId $conversationId): Conversation
    {
        /** @var ?Conversation $conversation */
        $conversation = $this->find($conversationId);
        if (null === $conversation) {
            throw new ConversationNotFound($conversationId);
        }

        return $conversation;
    }

    /**
     * @throws \Exception
     */
    public function listCursorPagination(int $limit, string $field, string $direction, ?string $cursor): CursorPagination
    {
        $queryBuilder = $this->createQueryBuilder(self::ALIAS);

        return new DoctrineCursorPagination($queryBuilder, $limit, $field, $direction, $cursor);
    }
}
