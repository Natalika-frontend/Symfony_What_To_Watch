<?php

namespace App\DataFixtures;

use App\Entity\FavoriteFilm;
use App\Entity\Film;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class FavoriteFilmFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $users = $manager->getRepository(User::class)->findAll();
        $films = $manager->getRepository(Film::class)->findAll();

        foreach ($users as $user) {
            foreach ($faker->randomElements($films, rand(1, 3)) as $film) {
                $fav = new FavoriteFilm();
                $fav->setUser($user);
                $fav->setFilm($film);
                $manager->persist($fav);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixture::class,
            FilmFixture::class,
        ];
    }
}
