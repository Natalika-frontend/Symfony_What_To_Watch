<?php

declare(strict_types=1);

namespace App\Controller;

use App\Message\SendWelcomeEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

class MessageController extends AbstractController
{
    /**
     * @throws ExceptionInterface
     */
    #[Route('/test-send', name: 'send_welcome_email')]
    public function send(MessageBusInterface $bus) : Response
    {
        $bus->dispatch(new SendWelcomeEmail(
            'user@example.com',
                'Привет! Сообщение через симфони))'
            )
        );

        return new Response('Сообщение отправлено!!!');
    }
}
