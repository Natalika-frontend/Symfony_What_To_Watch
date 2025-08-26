<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user_self_profile', methods: ['GET'])]
    public function index(): Response
    {
        return $this->json([]);
    }

    #[Route('/user', name: 'app_user_update_profile', methods: ['PATCH'])]
    public function update(): Response
    {
        return $this->json([]);
    }
}
