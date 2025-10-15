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
    /**
     *  Отображение формы регистрации (GET /register)
     */
    #[Route('/register', name: 'app_register_form', methods: ['GET'])]
    public function showForm(): Response
    {
        return $this->render('auth/registerForm.html.twig');
    }

    /**
     *  Обработка формы регистрации (POST /register)
     */
    #[Route('/register', name: 'app_register', methods: ['POST'])]
    public function register(Request $request, RegisterService $registerService): Response
    {
        // Если запрос пришёл из браузера (форма)
        if ($request->headers->get('Content-Type') !== 'application/json') {
            $name = $request->request->get('name');
            $email = $request->request->get('email');
            $password = $request->request->get('password');

            $dto = new RegisterDto($name, $email, $password);
            $registerService->register($dto);

            // После успешной регистрации — редирект на страницу логина
            $this->addFlash('success', 'Регистрация прошла успешно!');
            return $this->redirectToRoute('app_login');
        }

        // Если запрос API (JSON)
        $data = json_decode($request->getContent(), true);
        $dto = new RegisterDto(
            $data['name'] ?? '',
            $data['email'] ?? '',
            $data['password'] ?? ''
        );

        $result = $registerService->register($dto);
        return $this->json($result, Response::HTTP_CREATED);
    }
}
