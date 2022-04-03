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

class UpdateGroupCommand extends Command
{
    private ServerClient $serverClient;

    public function __construct(ServerClient $serverClient)
    {
        parent::__construct();

        $this->serverClient = $serverClient;
    }

    protected function configure(): void
    {
        $this->setName('group:update');
        $this->setDescription('This command update a group');
        $this->setHelp('name - unique string');
        $this->addArgument('groupId', InputArgument::REQUIRED, 'The group id.');
        $this->addArgument('name', InputArgument::REQUIRED, 'The name of the group.');
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln([
            'Group Updater',
            '============',
        ]);
        $output->writeln('GroupID: ' . $input->getArgument('groupId'));
        $output->writeln('Name: ' . $input->getArgument('name'));

        $output->writeln([
            '============',
            'Send request to API server'
        ]);

        try {
            $result = $this->serverClient->updateGroup(
                $input->getArgument('groupId'),
                $input->getArgument('name'),
            );
            $output->writeln($result);
        } catch (Exception $exception) {
            $output->writeln($exception->getMessage());
        }

        return Command::SUCCESS;
    }
}
