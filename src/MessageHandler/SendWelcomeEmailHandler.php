<?php

namespace App\MessageHandler;

use App\Message\SendWelcomeEmail;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class SendWelcomeEmailHandler
{
    public function __invoke(SendWelcomeEmail $message): void
    {
        $email = $message->getEmail();
        $name = $message->getName();

        file_put_contents(
            __DIR__ . '/../../var/log/welcome_email.log',
            "Send welcome email to $email ($name)\n",
            FILE_APPEND
        );
    }
}
