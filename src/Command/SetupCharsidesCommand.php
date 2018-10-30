<?php

namespace App\Command;

use App\Entity\CharClass;
use App\Entity\CharSide;
use App\Entity\PartyRole;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;


class SetupCharsidesCommand extends Command
{
    protected static $defaultName = 'app:setup:charsides';
    private $container;

    public function __construct($name = null, ContainerInterface $container)
    {
        parent::__construct($name);
        $this->container = $container;
    }

    protected function configure()
    {
        $this
            ->setDescription('Setup default values for game char sides')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $em = $this->container->get('doctrine')->getManager();
        $existed = $em->getRepository('App:CharSide')->findAll();
        if (count($existed) > 0) {
            $io->error("Can't setup, because some records already exists");
            die(1);
        }

        $dark = new CharSide();
        $dark->setName('Dark');
        $em->persist($dark);

        $light = new CharSide();
        $light->setName('Light');
        $em->persist($light);

        $no = new CharSide();
        $no->setName('No side');
        $em->persist($no);

        try {
            $em->flush();
        } catch (\Exception $e) {
            $io->error("Cannot save initial data: ".$e->getMessage());
            die(1);
        }
        $io->success('Initial char sides data saved');

    }
}
