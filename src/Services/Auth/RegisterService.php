<?php

namespace App\Services\Auth;

use App\Dto\Auth\RegisterDto;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Uid\Uuid;

final readonly class RegisterService
{
    public function __construct(
        private UserRepository $userRepository,
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    public function register(RegisterDto $dto): array
    {
        $email = trim($dto->email);
        if ($this->userRepository->findOneBy(['email' => $email])) {
            throw new CustomUserMessageAuthenticationException('Email already registered');
        }

        $user = new User();
        $user->setName($dto->name);
        $user->setEmail($dto->email);
        $user->setPassword($this->passwordHasher->hashPassword($user, $dto->password));
        $user->setApiToken(Uuid::v4()->toRfc4122());
        $user->setRoles(['ROLE_USER']);

        $this->userRepository->save($user, true);

        return [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'apiToken' => $user->getApiToken(),
        ];
    }
}
