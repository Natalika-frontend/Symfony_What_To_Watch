<?php

namespace App\Dto\User;

final class UserDto
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email
    ) {}
}
