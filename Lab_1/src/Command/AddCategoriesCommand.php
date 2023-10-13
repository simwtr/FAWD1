<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Category;

class AddCategoriesCommand extends Command
{
    protected static $defaultName = 'app:add-categories-command';

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this
            ->setDescription('Add categories to the database')
            ->setHelp('This command adds sample categories to the database');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $category1 = new Category();
        $category1->name = 'Category 1'; 
        $this->entityManager->persist($category1);

        $category2 = new Category();
        $category2->name = 'Category 2';
        $this->entityManager->persist($category2);

        $this->entityManager->flush();

        $output->writeln('Categories added to the database.');

        return Command::SUCCESS;
    }
}