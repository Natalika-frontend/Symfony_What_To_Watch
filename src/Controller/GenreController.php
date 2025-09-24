<?php

namespace App\Controller;

use App\Services\Genre\GenreService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/genres')]
final class GenreController extends AbstractController
{
    private GenreService $genreService;

    public function __construct(GenreService $genreService)
    {
        $this->genreService = $genreService;
    }

    #[Route('', name: 'app_genre', methods: ['GET'])]
    public function index(): Response
    {
        $genres = $this->genreService->getAllGenres();

        return $this->json([
            'data' => $genres,
        ]);
    }

    #[Route('', name: 'app_update_genre', methods: ['PATCH'])]
    public function update(): Response
    {
        return $this->json([]);
    }
}
