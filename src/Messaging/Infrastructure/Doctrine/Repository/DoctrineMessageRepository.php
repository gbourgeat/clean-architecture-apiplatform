<?php

declare(strict_types=1);

namespace App\Messaging\Infrastructure\Doctrine\Repository;

use App\Messaging\Domain\Entity\Message;
use App\Messaging\Domain\Repository\MessageRepository;
use App\Messaging\Domain\ValueObject\ConversationId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @template-extends ServiceEntityRepository<Message>
 */
class DoctrineMessageRepository extends ServiceEntityRepository implements MessageRepository
{
    public const ALIAS = 'message';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }

    /**
     * @return Message[]
     */
    public function searchByConversationId(ConversationId $conversationId, int $page, int $itemsPerPage): array
    {
        $queryBuilder = $this->createQueryBuilder(self::ALIAS);
        $expressionBuilder = $queryBuilder->expr();
        $offset = ($page - 1) * $itemsPerPage;

        $query = $queryBuilder
            ->where($expressionBuilder->eq(self::ALIAS.'.conversation', ':conversationId'))
            ->setParameter('conversationId', $conversationId)
            ->orderBy($expressionBuilder->desc(self::ALIAS.'.sentAt'))
            ->setFirstResult($offset)
            ->setMaxResults($itemsPerPage)
            ->getQuery();

        return $query->getResult();
    }
}
