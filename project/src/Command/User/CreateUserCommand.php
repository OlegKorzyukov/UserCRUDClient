<?php

namespace App\Command\User;

use App\Service\ServerClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class CreateUserCommand extends Command
{
    private ServerClient $serverClient;

    public function __construct(ServerClient $serverClient)
    {
        parent::__construct();

        $this->serverClient = $serverClient;
    }

    protected function configure()
    {
        $this->setName('user:create');
        $this->setDescription('This command create a new user');
        $this->setHelp('');
        $this->addArgument('username', InputArgument::REQUIRED, 'The username of the user.');
        $this->addArgument('email', InputArgument::REQUIRED, 'The email of the user.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'User Creator',
            '============',
        ]);
        $output->writeln('Username: ' . $input->getArgument('username'));
        $output->writeln('Email: ' . $input->getArgument('email'));

        $output->writeln([
            '============',
            'Send request to API server'
        ]);

        $this->serverClient->createUser($input->getArgument('username'), $input->getArgument('email'));

        return Command::SUCCESS;
    }
}
