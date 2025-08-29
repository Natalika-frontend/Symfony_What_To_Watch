<?php

namespace App\DataFixtures;

use App\Entity\Film;
use App\Entity\Genre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class FilmFixture extends Fixture
{
    public function getDependencies(): array
    {
        return [GenreFixture::class];
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $genres = $manager->getRepository(Genre::class)->findAll();

        for ($i = 0; $i < 10; $i++) {
            $film = new Film();
            $film->setName($faker->sentence(3));
            $film->setStatus('ready');
            $film->setReleased($faker->year());
            $film->setDescription($faker->paragraph());
            $film->setRunTime($faker->numberBetween(80, 180) . ' min');
            $film->setRating($faker->randomFloat(1, 1, 10));
            $film->setPosterImage($faker->imageUrl(200, 300));
            $film->setIsPromo($faker->boolean(20));

            if (!empty($genres)) {
                foreach ($faker->randomElements($genres, rand(1, min(3, count($genres)))) as $genre) {
                    $film->addGenre($genre);
                }
            }

            $manager->persist($film);
        }

        $manager->flush();
    }
}
