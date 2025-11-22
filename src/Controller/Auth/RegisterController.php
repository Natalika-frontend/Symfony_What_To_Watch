<?php

namespace App\Controller\Auth;

use App\Dto\Auth\RegisterDto;
use App\Form\RegisterType;
use App\Services\Auth\RegisterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class RegisterController extends AbstractController
{
    #[Route('/register', name: 'app_register_form', methods: ['GET', 'POST'])]
    public function register(
        Request $request,
        RegisterService $registerService,
        ValidatorInterface $validator
    ): Response {
        // Проверяем формат
        $isJson = $request->getContentTypeFormat() === 'json';

        $dto = new RegisterDto();
        $form = $this->createForm(RegisterType::class, $dto);
        $form->handleRequest($request);

        // форма
        if (!$isJson) {
            $form = $this->createForm(RegisterType::class);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $registerService->register($dto);

                $this->addFlash('success', 'Регистрация прошла успешно!');
                return $this->redirectToRoute('app_login');
            }

            // Возвращаем HTML форму
            return $this->render('auth/registerForm.html.twig', [
                'form' => $form->createView(),
            ]);
        }

        // JSON-запрос (Postman, API)
        $data = json_decode($request->getContent(), true) ?? [];

        $dto = new RegisterDto(
            $data['name'] ?? '',
            $data['email'] ?? '',
            $data['password'] ?? ''
        );

        $errors = $validator->validate($dto);

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[$error->getPropertyPath()] = $error->getMessage();
            }

            return $this->json([
                'status' => 'error',
                'errors' => $errorMessages,
            ], Response::HTTP_BAD_REQUEST);
        }

        $result = $registerService->register($dto);

        return $this->json($result, Response::HTTP_CREATED);
    }
}
