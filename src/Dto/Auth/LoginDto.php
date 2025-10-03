<?php

namespace App\Dto\Auth;

final class LoginDto
{
    public function __construct(
        public string $email,
        public string $password
    ) {}
}
