<?php

namespace App\Dto\Genre;

final class GenreDto
{
    public function __construct(
        public int $id,
        public string $name
    ) {}
}
