<?php

namespace App\Mapper\Favorite;

use App\Entity\FavoriteFilm;

final class FavoriteMapper
{
    public static function map(FavoriteFilm $favorite): array
    {
        return [
            'id' => $favorite->getFilm()->getId(),
            'name' => $favorite->getFilm()->getName(),
            'preview_image' => $favorite->getFilm()->getPreviewImage(),
        ];
    }

    public static function mapCollection(iterable $favorites): array
    {
        return array_map(
            fn(FavoriteFilm $f) => self::map($f),
            is_array($favorites) ? $favorites : iterator_to_array($favorites)
        );
    }
}
