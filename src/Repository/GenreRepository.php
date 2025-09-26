<?php

namespace App\Repository;

use App\Entity\Genre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Genre>
 */
class GenreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Genre::class);
    }

    public function findAllGenres() : array
    {
        return $this->findAll();
    }

    public function findGenreById(string $id) : ?Genre
    {
        return $this->find($id);
    }

    public function save(Genre $genre) : void
    {
        $em = $this->getEntityManager();
        $em->persist($genre);
        $em->flush();
    }
}
