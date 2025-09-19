<?php

namespace App\Dto\Film;

use DateTimeInterface;

final class FilmCreateDto
{
    public string $name;
    public ?string $status = 'ready';
    public ?string $description = null;
    public ?DateTimeInterface $released = null;
    public ?string $poster = null;
}
