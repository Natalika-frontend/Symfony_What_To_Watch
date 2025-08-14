<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/films')]
final class FilmController extends AbstractController
{
    #[Route('', name: 'app_films_list', methods: ['GET'])]
    public function index() : JsonResponse
    {
        return $this->json([]);
    }

    #[Route('/{id}', name: 'app_film_show', methods: ['GET'])]
    public function show() : JsonResponse
    {
        return $this->json([]);
    }

    #[Route('', name: 'app_film_create', methods: ['POST'])]
    public function new() : JsonResponse
    {
        return $this->json([]);
    }

    #[Route('/{id}', name: 'app_film_update', methods: ['PATCH'])]
    public function update() : JsonResponse
    {
        return $this->json([]);
    }

    #[Route('/similar', name: 'app_film_similar', methods: ['GET'])]
    public function similar() : JsonResponse
    {
        return $this->json([]);
    }
}
