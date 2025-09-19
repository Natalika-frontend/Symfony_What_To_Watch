<?php

namespace App\Mapper\Film;

use App\Dto\Film\FilmCreateDto;
use App\Dto\Film\FilmDetailDto;
use App\Dto\Film\FilmListDto;
use App\Dto\Film\FilmUpdateDto;
use App\Entity\Film;

final class FilmMapper
{
    public static function toListDto(Film $film): FilmListDto
    {
        return new FilmListDto(
            $film->getId(),
            $film->getName(),
            (int)$film->getReleased(),
            $film->getPosterImage()
        );
    }

    public static function toDetailDto(Film $film): FilmDetailDto
    {
        return new FilmDetailDto(
            $film->getId(),
            $film->getName(), (int)$film->getReleased(),
            $film->getDescription(),
            array_map(fn($g) => $g->getName(), $film->getGenres()->toArray()),
            array_map(fn($a) => $a->getName(), $film->getActors()->toArray()),
            array_map(fn($d) => $d->getName(), $film->getDirectors()->toArray()),
        );
    }

    public static function fromCreateDto(FilmCreateDto $dto): Film
    {
        $film = new Film();
        $film->setName($dto->name);
        $film->setStatus($dto->status ?? 'ready');
        $film->setDescription($dto->description);
        $film->setReleased($dto->released);
        $film->setPosterImage($dto->poster);

        return $film;
    }

    public static function updateEntityFromDto(Film $film, FilmUpdateDto $dto): Film
    {
        if ($dto->name !== null) {
            $film->setName($dto->name);
        }
        if ($dto->status !== null) {
            $film->setStatus($dto->status);
        }
        if ($dto->description !== null) {
            $film->setDescription($dto->description);
        }

        return $film;
    }
}
