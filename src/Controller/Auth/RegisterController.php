<?php

namespace App\Controller\Auth;

use App\Dto\Auth\RegisterDto;
use App\Form\RegisterType;
use App\Services\Auth\RegisterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RegisterController extends AbstractController
{
    #[Route('/register', name: 'app_register_form', methods: ['GET', 'POST'])]
    public function register(Request $request, RegisterService $registerService): Response
    {
        $form = $this->createForm(RegisterType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $dto = new RegisterDto(
                $data['name'],
                $data['email'],
                $data['password']
            );

            $registerService->register($dto);

            $this->addFlash('success', 'Регистрация прошла успешно!');
            return $this->redirectToRoute('app_login');
        }

        // Oбычная форма
        if ($request->getContentTypeFormat() !== 'json') {
            return $this->render('auth/registerForm.html.twig', [
                'form' => $form->createView(),
            ]);
        }

        // API-запрос
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
