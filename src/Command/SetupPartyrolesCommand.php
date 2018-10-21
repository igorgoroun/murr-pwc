<?php

namespace App\Command;

use App\Entity\PartyRole;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;


class SetupPartyrolesCommand extends Command
{
    protected static $defaultName = 'app:setup:partyroles';
    private $container;

    public function __construct($name = null, ContainerInterface $container)
    {
        parent::__construct($name);
        $this->container = $container;
    }

    protected function configure()
    {
        $this
            ->setDescription('Setup default values for game party roles')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $em = $this->container->get('doctrine')->getManager();
        $existed = $em->getRepository('App:PartyRole')->findAll();
        if (count($existed) > 0) {
            $io->error("Can't setup, because some records already exists");
            die(1);
        }

        $tank = new PartyRole();
        $tank->setName('Tank');
        $em->persist($tank);

        $support = new PartyRole();
        $support->setName('Support');
        $em->persist($support);

        $heal = new PartyRole();
        $heal->setName('Healer');
        $em->persist($heal);

        $dd = new PartyRole();
        $dd->setName('Damage dealer');
        $em->persist($dd);

        $other = new PartyRole();
        $other->setName('Other');
        $em->persist($other);

        try {
            $em->flush();
        } catch (\Exception $e) {
            $io->error("Cannot save initial data: ".$e->getMessage());
            die(1);
        }
        $io->success('Initial party roles data saved');

    }
}
