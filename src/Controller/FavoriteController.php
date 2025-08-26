<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FavoriteController extends AbstractController
{
    #[Route('/favorite', name: 'app_favorite', methods: ['GET'])]
    public function index(): Response
    {
        return $this->json([]);
    }

    #[Route('/films/{id}/favorite', name: 'app_add_favorite', methods: ['POST'])]
    public function new(): Response
    {
        return $this->json([]);
    }

    #[Route('/films/{id}/favorite', name: 'app_delete_favorite', methods: ['DELETE'])]
    public function delete(): Response
    {
        return $this->json([]);
    }
}
