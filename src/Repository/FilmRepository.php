<?php

namespace App\Repository;

use App\Entity\Film;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

class FilmRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Film::class);
    }

    public function findForList(
        int $page = 1,
        int $limit = Film::PAGINATION_LIMIT,
        ?array $genres = null,
        ?string $status = null,
        ?string $orderBy = 'released',
        ?string $orderDirection = 'desc'
    ): Paginator
    {
        $qb = $this->createQueryBuilder('f')
            ->distinct()
            ->leftJoin('f.genres', 'g')->addSelect('g')
            ->leftJoin('f.actors', 'a')->addSelect('a');

        if ($status) {
            $qb->andWhere('f.status = :status')
                ->setParameter('status', $status);
        }

        if ($genres && count($genres) > 0) {
            $qb->andWhere('g.name IN (:genres)')
                ->setParameter('genres', $genres);
        }

        $orderByField = in_array($orderBy, ['released', 'rating']) ? 'f.' . $orderBy : 'f.released';
        $orderDir = strtolower($orderDirection) === 'desc' ? 'DESC' : 'ASC';
        $qb->orderBy($orderByField, $orderDir);

        $qb->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit);

        return new Paginator($qb);
    }

    public function findForShow(int $id): ?Film
    {
        return $this->createQueryBuilder('f')
            ->leftJoin('f.genres', 'g')->addSelect('g')
            ->leftJoin('f.actors', 'a')->addSelect('a')
            ->leftJoin('f.directors', 'd')->addSelect('d')
            ->andWhere('f.id = :id')->setParameter('id', $id)
            ->getQuery()->getOneOrNullResult();
    }

    public function findPromoFilm(): ?Film
    {
        return $this->findOneBy(['isPromo' => true]);
    }

    public function save(Film $film): void
    {
        $this->_em->persist($film);
        $this->_em->flush();
    }

    public function delete(Film $film): void
    {
        $this->_em->remove($film);
        $this->_em->flush();
    }

    public function findSimilarByGenres(Film $film, int $limit = 5): array
    {
        $genreIds = $film->getGenres()->map(fn($g) => $g->getId())->toArray();

        if (empty($genreIds)) {
            return [];
        }

        return $this->createQueryBuilder('f')
            ->join('f.genres', 'g')
            ->where('g.id IN (:genreIds)')
            ->andWhere('f.id != :id')
            ->setParameter('genreIds', $genreIds)
            ->setParameter('id', $film->getId())
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
