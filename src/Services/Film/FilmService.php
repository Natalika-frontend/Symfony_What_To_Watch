<?php

namespace App\Services\Film;

use App\Dto\Film\FilmCreateDto;
use App\Dto\Film\FilmDetailDto;
use App\Dto\Film\FilmUpdateDto;
use App\Entity\Film;
use App\Exceptions\EntityNotFoundException;
use App\Mapper\Film\FilmMapper;
use App\Repository\FilmRepository;
class FilmService
{
    private FilmRepository $filmRepository;
    public function __construct(
        FilmRepository $filmRepository
    )
    {
        $this->filmRepository = $filmRepository;
    }

    public function listFilms(int $page, int $limit): array
    {
        $paginator = $this->filmRepository->findForList($page, $limit);

        $films = [];
        foreach ($paginator as $film) {
            $films[] = FilmMapper::toListDto($film);
        }

        return [
            'data' => $films,
            'total' => $paginator->count(),
            'page' => $page,
            'limit' => $limit,
        ];
    }

    public function getFilm(int $filmId): FilmDetailDto
    {
        $film = $this->filmRepository->findForShow($filmId);

        if (!$film) {
            throw new EntityNotFoundException('Фильм не найден');
        }

        return FilmMapper::toDetailDto($film);
    }

    public function createFilm(FilmCreateDto $dto): Film
    {
        $film = FilmMapper::fromCreateDto($dto);
        $this->filmRepository->save($film);
        return $film;
    }

    public function updateFilm(int $id, FilmUpdateDto $dto): Film
    {
        $film = $this->filmRepository->find($id);
        if (!$film) {
            throw new EntityNotFoundException('Фильм не найден');
        }

        FilmMapper::updateEntityFromDto($film, $dto);
        $this->filmRepository->save($film, true);

        return $film;
    }

    public function findSimilar(int $id, int $limit = 5): array
    {
        $film = $this->filmRepository->find($id);
        if (!$film) {
            throw new EntityNotFoundException('Фильм не найден');
        }

        return $this->filmRepository->findSimilarByGenres($film, $limit);
    }
}
