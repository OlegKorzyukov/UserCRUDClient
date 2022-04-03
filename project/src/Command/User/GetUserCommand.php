<?php

namespace App\Command\User;

use App\Service\ServerClient;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class GetUserCommand extends Command
{
    private ServerClient $serverClient;

    public function __construct(ServerClient $serverClient)
    {
        parent::__construct();

        $this->serverClient = $serverClient;
    }

    protected function configure(): void
    {
        //TODO: make pagination parameter
        $this->setName('user:get');
        $this->setDescription('This command get all users');
        $this->setHelp('');
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
            'All Users',
            '============',
        ]);
        $output->writeln([
            '============',
            'Send request to API server'
        ]);

        $table = new Table($output);
        $table->setHeaders(['ID', 'Name', 'Email']);

        try {
            $result = json_decode($this->serverClient->getUsers());
            foreach ($result->data as $user) {
                $table->setRow($user->id, [$user->id, $user->name, $user->email]);
            }
            $table->render();
        } catch (Exception $exception) {
            $output->writeln($exception->getMessage());
        }

        return Command::SUCCESS;
    }
}
