<?php

namespace App\Controller;

use App\Services\Film\FilmService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/promo')]
final class PromoController extends AbstractController
{
    public function __construct(private FilmService $filmService) {}

    #[Route('', name: 'app_promo', methods: ['GET'])]
    public function index(): Response
    {
        $dto = $this->filmService->getPromoFilm();

        if (!$dto) {
            return $this->json(['message' => 'Promo film not found'], 404);
        }

        return $this->json(['data' => $dto]);
    }

    #[Route('/{id}', name: 'app_promo_create', methods: ['POST'])]
    public function setPromo(int $id): Response
    {
        try {
            $this->filmService->setPromoFilm($id);
            return $this->json(['message' => 'Успешно установлен промо'], 201);
        } catch (InvalidArgumentException $e) {
            return $this->json(['message' => $e->getMessage()], 404);
        }
    }
}
