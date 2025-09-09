<?php

namespace App\Command;

use App\Entity\Film;
use App\Entity\Genre;
use App\Entity\Director;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:test:relations')]
class TestRelationsCommand extends Command
{
    public function __construct(private EntityManagerInterface $em)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $film = new Film();
        $film->setName('Test Film');
        $film->setStatus('ready');

        $genre = $this->em->getRepository(Genre::class)->find(1);
        $director = $this->em->getRepository(Director::class)->find(1);

        $film->addGenre($genre);
        $film->addDirector($director);

        $this->em->persist($film);
        $this->em->flush();

        $output->writeln('Film saved with genre and director!');

        return Command::SUCCESS;
    }
}
