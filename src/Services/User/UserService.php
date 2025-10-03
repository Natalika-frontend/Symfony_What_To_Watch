<?php

namespace App\Services\User;

use App\Dto\User\UserDto;
use App\Mapper\User\UserMapper;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;

final readonly class UserService
{
    public function __construct(
        private UserRepository $userRepository,
        private EntityManagerInterface $em,
        private UserMapper $userMapper
    ) {}

    public function getUserById(int $id): UserDto
    {
        $user = $this->userRepository->find($id);

        if (!$user) {
            throw new RuntimeException('User not found');
        }

        return $this->userMapper->toDto($user);
    }

    public function updateUser(int $id, array $data): UserDto
    {
        $user = $this->userRepository->find($id);

        if (!$user) {
            throw new RuntimeException('User not found');
        }

        if (isset($data['name'])) {
            $user->setName($data['name']);
        }

        if (isset($data['email'])) {
            $user->setEmail($data['email']);
        }

        $this->em->persist($user);
        $this->em->flush();

        return $this->userMapper->toDto($user);
    }
}
