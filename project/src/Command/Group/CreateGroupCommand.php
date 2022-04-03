<?php

namespace App\Command\Group;

use App\Service\ServerClient;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class CreateGroupCommand extends Command
{
    private ServerClient $serverClient;

    public function __construct(ServerClient $serverClient)
    {
        parent::__construct();

        $this->serverClient = $serverClient;
    }

    protected function configure()
    {
        $this->setName('group:create');
        $this->setDescription('This command create a new group');
        $this->setHelp('name - unique string');
        $this->addArgument('name', InputArgument::REQUIRED, 'The name of the group.');
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Group Creator',
            '============',
        ]);
        $output->writeln('Name: ' . $input->getArgument('name'));

        $output->writeln([
            '============',
            'Send request to API server'
        ]);

        try {
            $result = $this->serverClient->createGroup($input->getArgument('name'));
            $output->writeln($result);
        } catch (Exception $exception) {
            $output->writeln($exception->getMessage());
        }

        return Command::SUCCESS;
    }
}
