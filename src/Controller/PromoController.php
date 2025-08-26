<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/promo')]
final class PromoController extends AbstractController
{
    #[Route('', name: 'app_promo', methods: ['GET'])]
    public function index(): Response
    {
        return $this->json([]);
    }

    #[Route('/{id}', name: 'app_promo_create', methods: ['GET'])]
    public function new(): Response
    {
        return $this->json([]);
    }
}
