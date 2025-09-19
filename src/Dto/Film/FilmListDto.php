<?php

namespace App\Dto\Film;

final class FilmListDto
{
    public int $id;
    public string $title;
    public int $year;
    public ?string $poster;

    public function __construct(int $id, string $title, int $year, ?string $poster)
    {
        $this->id = $id;
        $this->title = $title;
        $this->year = $year;
        $this->poster = $poster;
    }
}
