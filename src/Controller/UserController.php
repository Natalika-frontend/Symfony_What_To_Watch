<?php

namespace App\Controller;

use App\Mapper\User\UserMapper;
use App\Services\User\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{
    public function __construct(
        private readonly UserService $userService,
        private readonly UserMapper $userMapper
    ) {}

    #[Route('/user', name: 'app_user_self_profile', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $dto = $this->userService->getUserById(1);

        return $this->json([
            'data' => $this->userMapper->toArray($dto),
        ]);
    }

    #[Route('/user', name: 'app_user_update_profile', methods: ['PATCH'])]
    public function update(Request $request): JsonResponse
    {
        $newData = $request->toArray();

        $dto = $this->userService->updateUser(1, $newData);

        return $this->json([
            'message' => 'Профиль успешно обновлен',
            'data'    => $this->userMapper->toArray($dto),
        ]);
    }
}
