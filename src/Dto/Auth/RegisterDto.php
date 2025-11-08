<?php

namespace App\Dto\Auth;

use Symfony\Component\Validator\Constraints as Assert;

final class RegisterDto
{
    #[Assert\NotBlank(message: 'Имя обязательно для заполнения.')]
    #[Assert\Length(min: 2, max: 50, minMessage: 'Имя должно содержать минимум {{ limit }} символа.')]
    public ?string $name;

    #[Assert\NotBlank(message: 'Email обязателен.')]
    #[Assert\Email(message: 'Введите корректный email-адрес.')]
    public ?string $email;

    #[Assert\NotBlank(message: 'Пароль обязателен.')]
    #[Assert\Length(min: 6, minMessage: 'Пароль должен содержать минимум {{ limit }} символов.')]
    public ?string $password;

    public function __construct(string $name = null, string $email = null, string $password = null)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }
}
