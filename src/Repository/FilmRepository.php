<?php

namespace App\Repository;

use App\Entity\Film;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;

class FilmRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Film::class);
    }

    public function findForList(int $page = 1, int $limit = Film::PAGINATION_LIMIT): Paginator
    {
        $qb = $this->createQueryBuilder('f')
        ->leftJoin('f.genres', 'g')->addSelect('g')
        ->leftJoin('f.actors', 'a')->addSelect('a')
        ->orderBy('f.createdAt', 'DESC')
        ->setFirstResult(($page - 1) * $limit)
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
