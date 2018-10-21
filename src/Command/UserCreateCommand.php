<?php

namespace App\Command;

use App\Entity\User;
use App\Entity\UserGroup;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserCreateCommand extends Command
{
    protected static $defaultName = 'app:user:create';
    private $container;

    public function __construct($name = null, ContainerInterface $container, UserPasswordEncoderInterface $encoder)
    {
        parent::__construct($name);
        $this->container = $container;
        $this->encoder = $encoder;
    }

    protected function configure()
    {
        $this
            ->setDescription('Create new site user')
            ->addArgument('realname', InputArgument::REQUIRED, 'Real name')
            ->addArgument('nickname', InputArgument::REQUIRED, 'Char nickname')
            ->addArgument('email', InputArgument::REQUIRED, 'E-mail')
            ->addArgument('password', InputArgument::REQUIRED, 'Password')
            ->addOption('class', null, InputOption::VALUE_REQUIRED, 'Set class id')
            ->addOption('role', null, InputOption::VALUE_REQUIRED, 'Set user Role, one of:
                ROLE_GUEST
                ROLE_USER
                ROLE_MAJOR
                ROLE_GENERAL
                ROLE_MASTER
                ')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $em = $this->container->get('doctrine')->getManager();
        $user = new User();
        $user->setRealName($input->getArgument('realname'));
        $user->setNickName($input->getArgument('nickname'));
        $user->setEmail($input->getArgument('email'));
        $encoded = $this->encoder->encodePassword($user, $input->getArgument('password'));
        $user->setPassword($encoded);

        if ($input->getOption('role')) {
            $role = $em->getRepository('App:UserGroup')->findOneBy(['role'=>$input->getOption('role')]);
            if ($role && $role instanceof UserGroup) {
                $user->setUserRole($role);
            }
        }

        $em->persist($user);
        $em->flush();

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
    }
}
