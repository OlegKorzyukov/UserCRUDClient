<?php

namespace App\Command\Report;

use App\Service\ReportService;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Component\Console\Helper\Table;

class GetReportCommand extends Command
{
    private ReportService $reportService;

    public function __construct(ReportService $reportService)
    {
        parent::__construct();

        $this->reportService = $reportService;
    }

    protected function configure(): void
    {
        $this->setName('report:get');
        $this->setDescription('This command get report by users in groups');
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        //TODO: make async load (rabbitmq)
        $output->writeln([
            'Get report',
            '=======================',
        ]);
        $output->writeln('Send request to API server');
        $table = new Table($output);
        $table->setHeaders(['Groups', 'Users']);
        try {
            $result = $this->reportService->getArrayFromCSV($this->reportService->handle());
            $output->writeln('<info>Report file save on path ' . ReportService::getFullFilePatch() . '</info>');
            $i = 0;
            foreach ($result as $report) {
                $table->setRow($i, [$report[0], $report[1]]);
                $i++;
            }
            $table->render();
        } catch (Exception $exception) {
            $output->writeln($exception->getMessage());
        }

        return Command::SUCCESS;
    }
}
