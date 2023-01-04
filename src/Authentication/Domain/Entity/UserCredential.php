<?php

declare(strict_types=1);

namespace App\Authentication\Domain\Entity;

use App\Authentication\Domain\Exception\NewPasswordShouldBeDifferentOfCurrentPassword;
use App\Authentication\Domain\ValueObject\HashedPassword;
use App\Authentication\Domain\ValueObject\Username;
use App\User\Domain\ValueObject\UserId;

class UserCredential
{
    private function __construct(
        private readonly UserId $userId,
        private Username $username,
        private HashedPassword $hashedPassword,
    ) {
    }

    public static function create(
        UserId $userId,
        Username $username,
        HashedPassword $hashedPassword,
    ): UserCredential {
        return new self($userId, $username, $hashedPassword);
    }

    public function userId(): UserId
    {
        return $this->userId;
    }

    public function username(): Username
    {
        return $this->username;
    }

    public function hashedPassword(): HashedPassword
    {
        return $this->hashedPassword;
    }

    public function changeUsername(Username $username): void
    {
        $this->username = $username;
    }

    /**
     * @throws NewPasswordShouldBeDifferentOfCurrentPassword
     */
    public function changePassword(HashedPassword $hashedPassword): void
    {
        if ($this->hashedPassword()->isEqual($hashedPassword)) {
            throw new NewPasswordShouldBeDifferentOfCurrentPassword();
        }

        $this->hashedPassword = $hashedPassword;
    }
}
