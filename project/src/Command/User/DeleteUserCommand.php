<?php

namespace App\Command\User;

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

class DeleteUserCommand extends Command
{
    private ServerClient $serverClient;

    public function __construct(ServerClient $serverClient)
    {
        parent::__construct();

        $this->serverClient = $serverClient;
    }

    protected function configure(): void
    {
        $this->setName('user:delete');
        $this->setDescription('This command delete a user');
        $this->addArgument('userId', InputArgument::REQUIRED, 'The user id.');
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
            'User Deleting',
            '============',
        ]);
        $output->writeln('UserID: ' . $input->getArgument('userId'));
        $output->writeln([
            '============',
            'Send request to API server'
        ]);

        try {
            $result = $this->serverClient->deleteUser($input->getArgument('userId'),);
            $output->writeln($result);
        } catch (Exception $exception) {
            $output->writeln($exception->getMessage());
        }

        return Command::SUCCESS;
    }
}
