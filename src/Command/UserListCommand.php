<?php

namespace App\Command;

use App\Entity\User;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserListCommand extends Command
{
    protected static $defaultName = 'app:user:list';

    private $container;

    public function __construct($name = null, ContainerInterface $container)
    {
        parent::__construct($name);
        $this->container = $container;
    }

    protected function configure()
    {
        $this
            ->setDescription('List registered users')
            //->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            //->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        //$arg1 = $input->getArgument('arg1');

        /*if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }*/

        /*if ($input->getOption('option1')) {
            // ...
        }*/

        //$io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        $em = $this->container->get('doctrine')->getManager();
        $users = $em->getRepository('App:User')->findAll();
        $tb_lines = [];
        /** @var User $user */
        foreach ($users as $user) {
            $tb_lines []= [
                implode("\n", $user->getRoles()),
                $user->getRealName(),
                $user->getEmail(),
                $user->getCharClass()?$user->getCharClass()->getName():'-',
                $user->getNickName(),
                $user->getCharClass()?$user->getCharClass()->getPartyRole()->getName():'-'
            ];
        }

        $io->table(
            ['ROLES', 'Name', 'E-mail', 'Class', 'Nick', 'Party role'],
            $tb_lines
        );
    }
}
