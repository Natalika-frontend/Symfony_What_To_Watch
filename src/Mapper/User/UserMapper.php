<?php

namespace App\Mapper\User;

use App\Dto\User\UserDto;
use App\Entity\User;

final class UserMapper
{
    public function toDto(User $user): UserDto
    {
        return new UserDto(
            id: $user->getId(),
            name: $user->getName(),
            email: $user->getEmail()
        );
    }

    public function toArray(UserDto $dto): array
    {
        return [
            'id'    => $dto->id,
            'name'  => $dto->name,
            'email' => $dto->email,
        ];
    }
}
