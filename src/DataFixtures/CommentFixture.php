<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Film;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Exception;
use Faker\Factory;

class CommentFixture extends Fixture implements DependentFixtureInterface
{
    /**
     * @throws Exception
     */
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $users = $manager->getRepository(User::class)->findAll();
        $films = $manager->getRepository(Film::class)->findAll();

        if (empty($users) || empty($films)) {
            throw new Exception('Не найдены пользователи или фильмы для комментариев!');
        }

        for ($i = 0; $i < 20; $i++) {
            $comment = new Comment();
            $comment->setText($faker->sentence());
            $comment->setRate($faker->numberBetween(1, 10));
            $comment->setUser($faker->randomElement($users));
            $comment->setFilm($faker->randomElement($films));

            $manager->persist($comment);
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
