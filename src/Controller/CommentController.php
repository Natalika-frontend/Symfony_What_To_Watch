<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/comments')]
final class CommentController extends AbstractController
{
    #[Route('', name: 'api_comment_index', methods: ['GET'])]
    public function index() : JsonResponse
    {
        return $this->json([]);
    }

    #[Route('/{id}', name: 'api_comment_new', methods: ['POST'])]
    public function new() : JsonResponse
    {
        return $this->json([]);
    }

    #[Route('/{comment}', name: 'api_comment_edit', methods: ['PATCH'])]
    public function edit() : JsonResponse
    {
        return $this->json([]);
    }

    #[Route('/{id}', name: 'api_comment_delete', methods: ['DELETE'])]
    public function delete() : JsonResponse
    {
        return $this->json([]);
    }
}
