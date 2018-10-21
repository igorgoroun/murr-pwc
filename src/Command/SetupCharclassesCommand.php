<?php

namespace App\Command;

use App\Entity\CharClass;
use App\Entity\PartyRole;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;


class SetupCharclassesCommand extends Command
{
    protected static $defaultName = 'app:setup:charclasses';
    private $container;

    public function __construct($name = null, ContainerInterface $container)
    {
        parent::__construct($name);
        $this->container = $container;
    }

    protected function configure()
    {
        $this
            ->setDescription('Setup default values for game char classes')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $em = $this->container->get('doctrine')->getManager();
        $existed = $em->getRepository('App:CharClass')->findAll();
        if (count($existed) > 0) {
            $io->error("Can't setup, because some records already exists");
            die(1);
        }

        $roles = $em->getRepository('App:PartyRole');
        $role_tank = $roles->findOneBy(['name'=>'Tank']);
        $role_support = $roles->findOneBy(['name'=>'Support']);
        $role_heal = $roles->findOneBy(['name'=>'Healer']);
        $role_dd = $roles->findOneBy(['name'=>'Damage dealer']);

        if ($role_tank && $role_tank instanceof PartyRole) {
            $tank = new CharClass();
            $tank->setName('Werewolf');
            $tank->setPartyRole($role_tank);
            $em->persist($tank);
        }

        if ($role_support && $role_support instanceof PartyRole) {
            $warrior = new CharClass();
            $warrior->setName('Warrior');
            $warrior->setPartyRole($role_support);
            $em->persist($warrior);

            $druid = new CharClass();
            $druid->setName('Druid');
            $druid->setPartyRole($role_support);
            $em->persist($druid);
        }

        if ($role_heal && $role_heal instanceof PartyRole) {
            $priest = new CharClass();
            $priest->setName('Priest');
            $priest->setPartyRole($role_heal);
            $em->persist($priest);
        }

        if ($role_dd && $role_dd instanceof PartyRole) {
            $archer = new CharClass();
            $archer->setName('Archer');
            $archer->setPartyRole($role_dd);
            $em->persist($archer);

            $mage = new CharClass();
            $mage->setName('Mage');
            $mage->setPartyRole($role_dd);
            $em->persist($mage);
        }

        try {
            $em->flush();
        } catch (\Exception $e) {
            $io->error("Cannot save initial data: ".$e->getMessage());
            die(1);
        }
        $io->success('Initial char classes data saved');

    }
}
