<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Контроллер для работы с фильмами (CRUD + дополнительные методы).
 *
 * Префикс всех маршрутов: /films
 */
#[Route('/films')]
final class FilmController extends AbstractController
{
    /**
     * Получить список фильмов (с пагинацией).
     *
     * GET /films
     *
     * @return JsonResponse JSON с массивом фильмов и мета-данными пагинации
     */
    #[Route('', name: 'app_films_list', methods: ['GET'])]
    public function index() : JsonResponse
    {
        return $this->json([
            'data' => [
                [
                    'id' => 1,
                    'name' => 'The Grand Budapest Hotel',
                    'preview_image' => 'img/the-grand-budapest-hotel.jpg',
                ],
                [
                    'id' => 2,
                    'name' => 'The Film',
                    'preview_image' => 'img/the-film.jpg',
                ],
            ],
            'current_page' => 1,
            'first_page_url' => 'http://localhost:8000/api/films?page=1',
            'next_page_url' => null,
            'prev_page_url' => null,
            'per_page' => 6,
            'total' => 2,
            ]);
    }

    /**
     * Получить данные конкретного фильма.
     *
     * GET /films/{id}
     *
     * @param int $id Идентификатор фильма
     *
     * @return JsonResponse JSON с данными фильма
     */
    #[Route('/{id}', name: 'app_film_show', methods: ['GET'])]
    public function show(int $id) : JsonResponse
    {
        return $this->json(['id' => $id]);
    }

    /**
     * Создать новый фильм.
     *
     * POST /films
     *
     * @return JsonResponse JSON с данными созданного фильма
     */
    #[Route('', name: 'app_film_create', methods: ['POST'])]
    public function new() : JsonResponse
    {
        return $this->json([]);
    }

    /**
     * Обновить данные фильма.
     *
     * PATCH /films/{id}
     *
     * @param int $id Идентификатор фильма
     *
     * @return JsonResponse JSON с обновлёнными данными фильма
     */
    #[Route('/{id}', name: 'app_film_update', methods: ['PATCH'])]
    public function update(int $id) : JsonResponse
    {
        return $this->json(['id' => $id]);
    }

    /**
     * Получить список похожих фильмов.
     *
     * GET /films/{id}/similar
     *
     * @param int $id Идентификатор фильма
     *
     * @return JsonResponse JSON с массивом похожих фильмов
     */
    #[Route('/{id}/similar', name: 'app_film_similar', methods: ['GET'])]
    public function similar(int $id) : JsonResponse
    {
        return $this->json(['id' => $id]);
    }
}
