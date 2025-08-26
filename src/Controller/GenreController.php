<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/genres')]
final class GenreController extends AbstractController
{
    #[Route('', name: 'app_genre', methods: ['GET'])]
    public function index(): Response
    {
        return $this->json([]);
    }

    #[Route('', name: 'app_update_genre', methods: ['PATCH'])]
    public function update(): Response
    {
        return $this->json([]);
    }
}
