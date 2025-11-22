<?php

namespace App\Tests\Service;

use App\Dto\Auth\RegisterDto;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Services\Auth\RegisterService;
use DomainException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class RegisterServiceTest extends TestCase
{
    public function testRegisterCreatesUsers() : void
    {
        $dto = new RegisterDto('TestUser', 'testExample@mail.ru', 'password123');

        $userRepository = $this->createMock(UserRepository::class);
        $userRepository->method('findOneBy')->with(['email' => $dto->email])->willReturn(null);
        $userRepository->expects($this->once())->method('save');

        $passwordHasher = $this->createMock(UserPasswordHasherInterface::class);
        $passwordHasher->method('hashPassword')->willReturn('hashed-password');

        $service = new RegisterService($userRepository, $passwordHasher);

        $result = $service->register($dto);

        $this->assertArrayHasKey('id', $result);
        $this->assertEquals('testExample@mail.ru', $result['email']);
        $this->assertArrayHasKey('apiToken', $result);
    }

    public function testRegisterThrowsExceptionIfEmailExists() : void
    {
        $dto = new RegisterDto('Test User', 'exists@example.com', 'password123');

        $existingUser = $this->createMock(User::class);

        $userRepository = $this->createMock(UserRepository::class);
        $userRepository->method('findOneBy')->with(['email' => $dto->email])->willReturn($existingUser);

        $passwordHasher = $this->createMock(UserPasswordHasherInterface::class);

        $service = new RegisterService($userRepository, $passwordHasher);

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Email already registered');

        $service->register($dto);
    }
}
