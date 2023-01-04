<?php

declare(strict_types=1);

namespace App\User\UserInterface\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\User\Application\DTO\UserDTO;
use App\User\UserInterface\ApiPlatform\Processor\CreateUserProcessor;
use App\User\UserInterface\ApiPlatform\Provider\UserProvider;
use App\User\UserInterface\ApiPlatform\Provider\UsersProvider;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'User',
    operations: [
        new GetCollection(
            openapiContext: ['summary' => 'Search users'],
            provider: UsersProvider::class,
        ),
        new Get(
            openapiContext: ['summary' => 'Get user'],
            provider: UserProvider::class,
        ),
        new Post(
            openapiContext: ['summary' => 'Create user'],
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

    public static function fromUserDTO(UserDTO $userDTO): UserResource
    {
        return new self(
            id: $userDTO->id,
            firstName: $userDTO->firstName,
            lastName: $userDTO->lastName,
            email: $userDTO->email,
        );
    }
}
