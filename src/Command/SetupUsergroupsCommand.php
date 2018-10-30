<?php

namespace App\Command;

use App\Entity\UserGroup;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SetupUsergroupsCommand extends Command
{
    protected static $defaultName = 'app:setup:usergroups';
    private $container;

    public function __construct($name = null, ContainerInterface $container)
    {
        parent::__construct($name);
        $this->container = $container;
    }

    protected function configure()
    {
        $this
            ->setDescription('Setup default values for user groups')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $em = $this->container->get('doctrine')->getManager();
        $existed = $em->getRepository('App:UserGroup')->findAll();
        if (count($existed) > 0) {
            $io->error("Can't setup, because some records already exists");
            die(1);
        }

        // generating default values
        // ROLE_GUEST
        $guest = new UserGroup();
        $guest->setName('Guest');
        $guest->setRole('ROLE_GUEST');
        $em->persist($guest);
        // ROLE_USER
        $user = new UserGroup();
        $user->setName('Member');
        $user->setRole('ROLE_USER');
        $em->persist($user);
        // ROLE_CAPTAIN
        $cap = new UserGroup();
        $cap->setName('Captain');
        $cap->setRole('ROLE_CAPTAIN');
        $em->persist($cap);
        // ROLE_MAJOR
        $major = new UserGroup();
        $major->setName('Major');
        $major->setRole('ROLE_MAJOR');
        $em->persist($major);
        // ROLE_GENERAL
        $general = new UserGroup();
        $general->setName('General');
        $general->setRole('ROLE_GENERAL');
        $em->persist($general);
        // ROLE_MASTER
        $master = new UserGroup();
        $master->setName('Master');
        $master->setRole('ROLE_MASTER');
        $em->persist($master);
        // ROLE_ADMIN
        $admin = new UserGroup();
        $admin->setName('Administrator');
        $admin->setRole('ROLE_ADMIN');
        $em->persist($admin);

        try {
            $em->flush();
        } catch (\Exception $e) {
            $io->error("Cannot save initial data: ".$e->getMessage());
            die(1);
        }
        $io->success('Initial groups data saved');
    }
}
