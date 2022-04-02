<?php

namespace App\Command\User;

use App\Service\ServerClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class CreateUserCommand extends Command
{
    protected static $defaultName = 'user:create';
    private ServerClient $serverClient;

    public function __construct(ServerClient $serverClient)
    {
        parent::__construct();

        $this->serverClient = $serverClient;
    }

    protected function configure()
    {
        $this->addArgument('username', InputArgument::REQUIRED, 'The username of the user.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $output->writeln([
            'User Creator',
            '============',
            '',
        ]);

        $output->writeln('Username: '.$input->getArgument('username'));

        return Command::SUCCESS;

    }
}
