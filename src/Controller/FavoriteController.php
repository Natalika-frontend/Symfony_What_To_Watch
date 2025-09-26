<?php

namespace App\Controller;

use App\Mapper\Favorite\FavoriteMapper;
use App\Services\FavoriteFilm\FavoriteFilmService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FavoriteController extends AbstractController
{
    public function __construct(
        private readonly FavoriteFilmService $favoriteService,
    ) {}

    #[Route('/favorite', name: 'app_favorite', methods: ['GET'])]
    public function index(): Response
    {
        $userId = 1;
        $favorites = $this->favoriteService->getFavorites($userId);

        return $this->json([
            'data' => FavoriteMapper::mapCollection($favorites),
        ]);
    }

    #[Route('/films/{id}/favorite', name: 'app_add_favorite', methods: ['POST'])]
    public function new(int $id): Response
    {
        $userId = 1;

        $favorite = $this->favoriteService->addToFavorite($userId, $id);

        return $this->json([
            'message' => "Фильм успешно добавлен в избранное",
        ]);
    }

    #[Route('/films/{id}/favorite', name: 'app_delete_favorite', methods: ['DELETE'])]
    public function delete(int $id): Response
    {
        $userId = 1;

        $this->favoriteService->removeFromFavorite($userId, $id);

        return $this->json([
            'message' => 'Фильм удалён из избранного',
        ]);
    }
}
