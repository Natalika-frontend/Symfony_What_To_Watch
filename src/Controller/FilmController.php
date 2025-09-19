<?php

namespace App\Controller;

use App\Dto\Film\FilmCreateDto;
use App\Dto\Film\FilmUpdateDto;
use App\Entity\Film;
use App\Mapper\Film\FilmMapper;
use App\Services\Film\FilmService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Контроллер для работы с фильмами (CRUD + дополнительные методы).
 *
 * Префикс всех маршрутов: /films
 */
#[Route('/films')]
final class FilmController extends AbstractController
{
    private FilmService $filmService;

    public function __construct(FilmService $filmService)
    {
        $this->filmService = $filmService;
    }

    /**
     * Получить список фильмов (с пагинацией).
     *
     * GET /films
     *
     * @return JsonResponse JSON с массивом фильмов и мета-данными пагинации
     */
    #[Route('', name: 'app_films_list', methods: ['GET'])]
    public function index(Request $request) : JsonResponse
    {
        $page =
            $request->query->getInt('page', 1);
        $limit =
            $request->query->getInt('limit', Film::PAGINATION_LIMIT);

        $result = $this->filmService->listFilms($page, $limit);

        return $this->json($result);
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
        $film = $this->filmService->getFilm($id);

        return $this->json(['data' => $film]);
    }

    /**
     * Добавление фильма в бд
     *
     * POST /films
     *
     * @return JsonResponse JSON с данными созданного фильма
     * @throws \Exception
     */
    #[Route('', name: 'app_film_create', methods: ['POST'])]
    public function new(Request $request) : JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $dto = new FilmCreateDto();
        $dto->name = $data['name'];
        $dto->status = $data['status'] ?? 'ready';
        $dto->description = $data['description'] ?? null;
        $dto->released = isset($data['released']) ? new DateTime($data['released']) : null;
        $dto->poster = $data['poster'] ?? null;

        $film = $this->filmService->createFilm($dto);

        return $this->json([
            'message' => 'Фильм успешно добавлен!',
            'data' => $film,
        ]);
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
    public function update(int $id, Request $request) : JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $dto = new FilmUpdateDto();
        $dto->name = $data['name'] ?? null;
        $dto->status = $data['status'] ?? null;
        $dto->description = $data['description'] ?? null;

        $film = $this->filmService->updateFilm($id, $dto);

        return $this->json(['message' => 'Фильм обновлён', 'data' => $film]);
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
        $similar =
            $this->filmService->findSimilar($id);
        $data = array_map(fn(Film $film) => FilmMapper::toListDto($film), $similar);

        return $this->json(['data' => $similar],
            200,
            [],
            ['groups' => ['film:list']]);
    }
}
