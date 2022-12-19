<?php

declare(strict_types=1);

namespace App\Backoffice\Users\Domain\Repository;

use App\Backoffice\Users\Domain\Entity\User;
use App\Backoffice\Users\Domain\Exception\UserNotFoundWithEmail;
use App\Backoffice\Users\Domain\ValueObject\ExternalId;
use App\Backoffice\Users\Domain\ValueObject\UserId;
use App\Common\Domain\Repository\Repository;
use App\Common\Domain\ValueObject\Email;

/**
 * @extends Repository<User>
 */
interface UserRepository extends Repository
{
    public function add(User $user): void;

    public function get(UserId $id): User;

    public function getByExternalId(ExternalId $externalId): User;

    /**
     * @throws UserNotFoundWithEmail
     */
    public function getByEmail(Email $email): User;
}
