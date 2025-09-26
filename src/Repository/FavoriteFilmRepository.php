<?php

namespace App\Repository;

use App\Entity\FavoriteFilm;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FavoriteFilm>
 */
class FavoriteFilmRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FavoriteFilm::class);
    }

    public function findFavoritesByUser(User $user): array
    {
        return $this->findBy(['user' => $user]);
    }

    public function save(FavoriteFilm $favoriteFilm): void
    {
        $em = $this->getEntityManager();
        $em->persist($favoriteFilm);
        $em->flush();
    }

    public function remove(FavoriteFilm $favoriteFilm): void
    {
        $em = $this->getEntityManager();
        $em->remove($favoriteFilm);
        $em->flush();
    }
}
