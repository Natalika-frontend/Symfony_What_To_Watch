<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Контроллер для управления комментариями (CRUD для API).
 *
 * Префикс всех маршрутов: /comments
 */
#[Route('/comments')]
final class CommentController extends AbstractController
{
    /**
     * Получить список комментариев.
     *
     * GET /comments
     *
     * @return JsonResponse JSON с массивом комментариев
     */
    #[Route('', name: 'api_comment_index', methods: ['GET'])]
    public function index() : JsonResponse
    {
        return $this->json([]);
    }

    /**
     * Создать новый комментарий.
     *
     * POST /comments/{id}
     *
     * @param int $id Идентификатор сущности (например, фильма), к которой привязан комментарий
     *
     * @return JsonResponse JSON с данными созданного комментария
     */
    #[Route('/{id}', name: 'api_comment_new', methods: ['POST'])]
    public function new(int $id) : JsonResponse
    {
        return $this->json(['id' => $id]);
    }

    /**
     * Обновить существующий комментарий.
     *
     * PATCH /comments/{comment}
     *
     * @param int $comment Идентификатор комментария
     *
     * @return JsonResponse JSON с обновлёнными данными комментария
     */
    #[Route('/{comment}', name: 'api_comment_edit', methods: ['PATCH'])]
    public function edit(int $id) : JsonResponse
    {
        return $this->json(['id' => $id]);
    }

    /**
     * Удалить комментарий.
     *
     * DELETE /comments/{id}
     *
     * @param int $id Идентификатор комментария
     *
     * @return JsonResponse JSON с результатом удаления
     */
    #[Route('/{id}', name: 'api_comment_delete', methods: ['DELETE'])]
    public function delete(int $id) : JsonResponse
    {
        return $this->json(['id' => $id]);
    }
}
