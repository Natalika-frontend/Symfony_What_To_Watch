<?php

namespace App\Dto\Auth;

use DateTimeImmutable;

final readonly class LoginResponseDto
{
    public function __construct(
        public string $token,
        public DateTimeImmutable $expiresAt,
    ) {}
}
