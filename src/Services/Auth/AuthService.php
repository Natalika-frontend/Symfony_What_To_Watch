<?php

namespace App\Services\Auth;

use App\Dto\Auth\LoginDto;
use App\Dto\Auth\LoginResponseDto;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Random\RandomException;
use RuntimeException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final readonly class AuthService
{
    public function __construct(
        private UserRepository $userRepository,
        private UserPasswordHasherInterface $passwordHasher,
        private EntityManagerInterface $em
    ) {}

    /**
     * @throws RandomException
     */
    public function login(LoginDto $dto): LoginResponseDto
    {
        $user = $this->userRepository->findOneBy(['email' => $dto->email]);

        if (!$user) {
            throw new RuntimeException('User not found');
        }

        if (!$this->passwordHasher->isPasswordValid($user, $dto->password)) {
            throw new RuntimeException('Invalid credentials');
        }

        $token = bin2hex(random_bytes(16));

        $user->setApiToken($token);
        $this->em->persist($user);
        $this->em->flush();

        $expiresAt = new DateTimeImmutable('+1 day');

        return new LoginResponseDto(token: $token, expiresAt: $expiresAt);
    }
}
