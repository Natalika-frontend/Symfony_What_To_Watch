<?php

namespace App\Dto\Auth;

final class RegisterDto
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password
    ) {}
}
