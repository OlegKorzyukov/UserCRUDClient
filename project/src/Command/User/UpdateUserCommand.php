<?php

namespace App\Command\User;

use App\Service\ServerClient;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class UpdateUserCommand extends Command
{
    private ServerClient $serverClient;

    public function __construct(ServerClient $serverClient)
    {
        parent::__construct();

        $this->serverClient = $serverClient;
    }

    protected function configure()
    {
        $this->setName('user:update');
        $this->setDescription('This command update a user');
        $this->setHelp('username - string, email - unique string');
        $this->addArgument('userId', InputArgument::REQUIRED, 'The user id.');
        $this->addArgument('username', InputArgument::OPTIONAL, 'The username of the user.');
        $this->addArgument('email', InputArgument::OPTIONAL, 'The email of the user.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'User Updater',
            '============',
        ]);
        $output->writeln('UserID: ' . $input->getArgument('userId'));
        $output->writeln('Username: ' . $input->getArgument('username'));
        $output->writeln('Email: ' . $input->getArgument('email'));

        $output->writeln([
            '============',
            'Send request to API server'
        ]);

        try {
            $result = $this->serverClient->updateUser(
                $input->getArgument('userId'),
                $input->getArgument('username'),
                $input->getArgument('email')
            );
            $output->writeln($result);
        } catch (Exception $exception) {
            $output->writeln($exception->getMessage());
        }

        return Command::SUCCESS;
    }
}
