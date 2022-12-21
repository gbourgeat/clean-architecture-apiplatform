<?php

declare(strict_types=1);

namespace App\Backoffice\User\Domain\Repository;

use App\Backoffice\User\Domain\Entity\User;
use App\Backoffice\User\Domain\ValueObject\UserId;
use App\Common\Domain\Repository\Repository;

/**
 * @extends Repository<User>
 */
interface UserRepository extends Repository
{
    public function add(User $user): void;

    public function get(UserId $id): User;
}
