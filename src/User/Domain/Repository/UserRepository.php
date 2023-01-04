<?php

declare(strict_types=1);

namespace App\User\Domain\Repository;

use App\Common\Domain\Repository\Repository;
use App\Common\Domain\ValueObject\Email;
use App\User\Domain\Entity\User;
use App\User\Domain\Exception\UserNotFound;
use App\User\Domain\ValueObject\UserId;

/**
 * @extends Repository<User>
 */
interface UserRepository extends Repository
{
    public function add(User $user): void;

    /**
     * @throws UserNotFound
     */
    public function get(UserId $id): User;

    public function emailExist(Email $email): bool;

    public function search(int $pageNumber, int $itemsPerPage): array;
}
