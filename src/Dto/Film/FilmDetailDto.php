<?php

declare(strict_types=1);

namespace App\Dto\Film;

final class FilmDetailDto
{
    public int $id;
    public string $name;
    public ?string $posterImage;
    public ?string $previewImage;
    public ?string $backgroundImage;
    public ?string $backgroundColor;
    public ?string $videoLink;
    public ?string $previewVideoLink;
    public ?string $description;
    public ?float $rating;
    public ?array $genres;
    public ?array $actors;
    public ?array $directors;
    public ?string $runTime;
    public ?int $year;
    public bool $isFavorite;

    public function __construct(
        int $id,
        string $name,
        ?string $posterImage,
        ?string $previewImage,
        ?string $backgroundImage,
        ?string $backgroundColor,
        ?string $videoLink,
        ?string $previewVideoLink,
        ?string $description,
        ?float $rating,
        ?array $genres,
        ?array $actors,
        ?array $directors,
        ?string $runTime,
        ?int $year,
        bool $isFavorite
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->posterImage = $posterImage;
        $this->previewImage = $previewImage;
        $this->backgroundImage = $backgroundImage;
        $this->backgroundColor = $backgroundColor;
        $this->videoLink = $videoLink;
        $this->previewVideoLink = $previewVideoLink;
        $this->description = $description;
        $this->rating = $rating;
        $this->genres = $genres;
        $this->actors = $actors;
        $this->directors = $directors;
        $this->runTime = $runTime;
        $this->year = $year;
        $this->isFavorite = $isFavorite;
    }
}
