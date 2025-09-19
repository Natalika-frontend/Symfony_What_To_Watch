<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class GenreFixture extends Fixture implements OrderedFixtureInterface
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

    public function getOrder() : int
    {
        return 2;
    }
}
