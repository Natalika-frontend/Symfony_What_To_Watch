<?php

declare(strict_types=1);

namespace App\Dto\Film;

final class FilmDetailDto
{
    public int $id;
    public string $title;
    public int $year;
    public ?string $description;
    public array $genres;
    public array $actors;
    public array $directors;

    public function __construct(
        int $id,
        string $title,
        int $year,
        ?string $description,
        array $genres,
        array $actors,
        array $directors
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->year = $year;
        $this->description = $description;
        $this->genres = $genres;
        $this->actors = $actors;
        $this->directors = $directors;
    }
}
