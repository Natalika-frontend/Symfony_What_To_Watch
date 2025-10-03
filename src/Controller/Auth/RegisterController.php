<?php

namespace App\Controller\Auth;

use App\Dto\Auth\RegisterDto;
use App\Services\Auth\RegisterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RegisterController extends AbstractController
{
    #[Route('/register', name: 'app_register', methods: ['POST'])]
    public function register(Request $request, RegisterService $registerService): Response
    {
        $data = json_decode($request->getContent(), true);
        $dto = new RegisterDto($data['name'] ?? '', $data['email'] ?? '', $data['password'] ?? '');
        $result = $registerService->register($dto);
        return $this->json($result, Response::HTTP_CREATED);
    }
}
