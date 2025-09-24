<?php

namespace App\Services\Genre;

use App\Dto\Genre\GenreDto;
use App\Mapper\Genre\GenreMapper;
use App\Repository\GenreRepository;

final class GenreService
{
    private GenreRepository $repository;

    public function __construct(GenreRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return GenreDto[]
     */
    public function getAllGenres(): array
    {
        $genres = $this->repository->findAllGenres();
        return GenreMapper::mapEntitiesToDtos($genres);
    }
}
