<?php

namespace App\Message;

use Symfony\Component\Messenger\MessageBusInterface;

final readonly class SendWelcomeEmail
{
    public function __construct(
        private string $email,
        private string $name
    ) {}

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
