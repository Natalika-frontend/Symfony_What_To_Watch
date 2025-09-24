<?php

namespace App\Mapper\Genre;

use App\Dto\Genre\GenreDto;
use App\Entity\Genre;

final class GenreMapper
{
    public static function mapEntityToDto(Genre $genre): GenreDto
    {
        return new GenreDto(
            $genre->getId(),
            $genre->getName(),
        );
    }

    /**
     * @param Genre[] $genres
     * @return GenreDto[]
     */
    public static function mapEntitiesToDtos(array $genres): array
    {
        return array_map(fn (Genre $genre) => self::mapEntityToDto($genre), $genres);
    }
}
