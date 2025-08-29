<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GenreFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $genres = ['Action', 'Comedy', 'Drama', 'Horror', 'Sci-Fi'];

        foreach ($genres as $name) {
            $genre = new Genre();
            $genre->setName($name);
            $manager->persist($genre);
        }

        $manager->flush();
    }
}
