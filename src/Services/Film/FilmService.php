<?php

namespace App\Services\Film;

use App\Dto\Film\FilmCreateDto;
use App\Dto\Film\FilmDetailDto;
use App\Dto\Film\FilmUpdateDto;
use App\Entity\Film;
use App\Exceptions\EntityNotFoundException;
use App\Mapper\Film\FilmMapper;
use App\Repository\FilmRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;


readonly class FilmService
{
    public function __construct(
        private FilmRepository $filmRepository,
        private EntityManagerInterface $em,
        private CacheInterface $cache
    )
    {
    }

    public function listFilms(
        int $page,
        int $limit,
        ?array $genres = null,
        ?string $status = null,
        ?string $orderBy = 'released',
        ?string $orderDirection = 'desc',
    ): array
    {
        $cacheKey = sprintf(
            'films_page_%d_limit_%d_%s_%s_%s_%s',
            $page,
            $limit,
            $genres ? implode('-', $genres) : 'all',
            $status ?? 'all',
            $orderBy,
            $orderDirection
        );

        return $this->cache->get($cacheKey, function (ItemInterface $item) use ($page, $limit, $genres, $status, $orderBy, $orderDirection) {
            // Срок жизни кэша: 10 минут
            $item->expiresAfter(600);
            $paginator =
                $this->filmRepository->findForList(
                    $page,
                    $limit,
                    $genres,
                    $status,
                    $orderBy,
                    $orderDirection
                );

            $films =
                [];
            foreach ($paginator as $film) {
                $films[] =
                    FilmMapper::toListDto($film);
            }

            return [
                'data' => $films,
                'total' => $paginator->count(),
                'page' => $page,
                'limit' => $limit,
            ];
        });
    }

    public function getFilm(int $filmId): FilmDetailDto
    {
        $film = $this->filmRepository->findForShow($filmId);

        if (!$film) {
            throw new EntityNotFoundException('Фильм не найден');
        }

        return FilmMapper::toDetailDto($film);
    }

    public function getPromoFilm(): ?FilmDetailDto
    {
        $promoFilm = $this->filmRepository->findPromoFilm();

        if (!$promoFilm) {
            return null;
        }

        return $this->toDetailDto($promoFilm);;
    }

    public function toDetailDto(Film $film): FilmDetailDto
    {
        $isFavorite = false;

        return new FilmDetailDto(
            $film->getId(),
            $film->getName(),
            $film->getPosterImage(),
            $film->getPreviewImage(),
            $film->getBackgroundImage(),
            $film->getBackgroundColor(),
            $film->getVideoLink(),
            $film->getPreviewVideoLink(),
            $film->getDescription(),
            $film->getRating(),
            array_map(fn($g) => $g->getName(), $film->getGenres()->toArray()),
            array_map(fn($a) => $a->getName(), $film->getActors()->toArray()),
            array_map(fn($d) => $d->getName(), $film->getDirectors()->toArray()),
            $film->getRunTime(),
            $film->getReleased(),
            $isFavorite
        );
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
        $this->filmRepository->save($film);

        return $film;
    }

    public function setPromoFilm(int $filmId): void
    {
        $currentPromo = $this->filmRepository->findPromoFilm();
        if ($currentPromo) {
            $currentPromo->setIsPromo(false);
            $this->em->persist($currentPromo);
        }

        // Найти новый фильм
        $newPromo = $this->filmRepository->find($filmId);
        if (!$newPromo) {
            throw new \InvalidArgumentException("Film with ID {$filmId} not found");
        }

        $newPromo->setIsPromo(true);
        $this->em->persist($newPromo);

        $this->em->flush();
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
