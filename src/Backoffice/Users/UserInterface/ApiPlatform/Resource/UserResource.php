<?php

declare(strict_types=1);

namespace App\Backoffice\Users\UserInterface\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Backoffice\Users\Domain\Entity\User;
use App\Backoffice\Users\UserInterface\ApiPlatform\Processor\CreateUserProcessor;
use App\Backoffice\Users\UserInterface\ApiPlatform\Provider\UserProvider;
use App\Backoffice\Users\UserInterface\ApiPlatform\Provider\UsersProvider;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'User',
    operations: [
        new GetCollection(
            openapiContext: ['summary' => 'List users.'],
            provider: UsersProvider::class,
        ),
        new Get(
            openapiContext: ['summary' => 'Get user details.'],
            provider: UserProvider::class,
        ),
        new Post(
            openapiContext: ['summary' => 'Create new user.'],
            denormalizationContext: ['groups' => ['create']],
            validationContext: ['groups' => ['create']],
            processor: CreateUserProcessor::class,
        ),
    ],
)]
final class UserResource
{
    public function __construct(
        #[ApiProperty(readable: true, writable: false, identifier: true)]
        #[Groups(groups: ['read'])]
        public readonly string $id = '',

        #[Assert\Length(min: 1, max: 255)]
        #[Assert\NotNull(groups: ['register', 'create'])]
        #[Groups(groups: ['read', 'create'])]
        public readonly string $firstName = '',

        #[Assert\Length(min: 1, max: 255)]
        #[Assert\NotNull(groups: ['register', 'create'])]
        #[Groups(groups: ['read', 'create'])]
        public readonly string $lastName = '',

        #[Assert\Length(min: 1, max: 255)]
        #[Assert\Email]
        #[Assert\NotNull(groups: ['register', 'create'])]
        #[Groups(groups: ['read', 'create'])]
        public readonly string $email = '',
    ) {
    }

    public static function fromEntity(User $user): UserResource
    {
        return new self(
            (string) $user->id(),
            (string) $user->firstName(),
            (string) $user->lastName(),
            (string) $user->email(),
        );
    }
}
