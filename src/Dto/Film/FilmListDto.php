<?php

namespace App\Dto\Film;

final class FilmListDto
{
    public int $id;
    public string $name;
    public ?string $preview_image;

    public function __construct(int $id, string $name, ?string $preview_image)
    {
        $this->id = $id;
        $this->name = $name;
        $this->preview_image = $preview_image;
    }
}
