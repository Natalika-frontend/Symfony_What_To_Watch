<?php

namespace App\Services\FavoriteFilm;

use App\Entity\FavoriteFilm;
use App\Repository\FavoriteFilmRepository;
use App\Repository\FilmRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;

final class FavoriteFilmService
{
    public function __construct(
        private readonly FavoriteFilmRepository $favoriteRepository,
        private readonly UserRepository $userRepository,
        private readonly FilmRepository $filmRepository,
        private EntityManagerInterface $em,
    ) {}

    public function getFavorites(int $userId): array
    {
        return $this->favoriteRepository->findBy(['user' => $userId]);
    }

    public function addToFavorite(int $userId, int $filmId): FavoriteFilm|array
    {
        $user = $this->userRepository->find($userId);
        if (!$user) {
            throw new RuntimeException("Пользователь не найден");
        }

        $film = $this->filmRepository->find($filmId);
        if (!$film) {
            throw new RuntimeException("Фильм не найден");
        }

        $existing = $this->favoriteRepository->findOneBy([
            'user' => $user,
            'film' => $film,
        ]);

        if ($existing) {
            throw new RuntimeException("Фильм уже в избранном");
        }

        $favorite = new FavoriteFilm();
        $favorite->setUser($user);
        $favorite->setFilm($film);

        $this->em->persist($favorite);
        $this->em->flush();

        return $favorite;
    }

    public function removeFromFavorite(int $userId, int $filmId): void
    {
        $user = $this->userRepository->find($userId);
        if (!$user) {
            throw new RuntimeException('Пользователь не найден');
        }

        $film = $this->filmRepository->find($filmId);
        if (!$film) {
            throw new RuntimeException('Фильм не найден');
        }

        $favorite = $this->favoriteRepository->findOneBy([
            'user' => $userId,
            'film' => $filmId,
        ]);

        if ($favorite) {
            $this->em->remove($favorite);
            $this->em->flush();
        } else {
            throw new RuntimeException('Фильм не найден в избранном');
        }
    }
}
