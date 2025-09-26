<?php

namespace App\Services\Genre;

use App\Dto\Genre\GenreDto;
use App\Entity\Genre;
use App\Mapper\Genre\GenreMapper;
use App\Repository\GenreRepository;
use RuntimeException;

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

    public function getGenreById(int $id): ?Genre
    {
        return $this->repository->findGenreById($id);
    }

    public function updateGenreName(int $id, string $newName): void
    {
        $genre = $this->getGenreById($id);

        if (!$genre) {
            throw new RuntimeException("Жанр с ID $id не найден");
        }

        $genre->setName($newName);

        $this->repository->save($genre);
    }
}
