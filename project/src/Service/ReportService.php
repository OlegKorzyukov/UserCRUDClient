<?php

namespace App\Service;

use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class ReportService
{
    private const FILE_PREFIX = 'group_user';
    private const FILE_PATCH = '/tmp/files/';
    private const FILE_FORMAT = '.csv';

    private ServerClient $client;
    private Filesystem $filesystem;

    public function __construct(ServerClient $client, Filesystem $filesystem)
    {
        $this->client = $client;
        $this->filesystem = $filesystem;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function handle(): string
    {
        $response = $this->client->getReport();
        $this->saveReport($response);

        return $response;
    }

    public function saveReport(string $response): string
    {
        try {
            $this->filesystem->dumpFile(self::getFullFilePatch(), $response);
            return self::getFullFilePatch();
        } catch (\Exception $exception) {
            throw new IOException('Error save report file');
        }
    }

    public static function getFullFilePatch(): string
    {
        return self::FILE_PATCH . self::FILE_PREFIX . self::FILE_FORMAT;
    }

    public function getArrayFromCSV(string $csvData): array
    {
        $lines = explode(PHP_EOL, $csvData);
        $result = [];
        foreach ($lines as $line) {
            $result[] = str_getcsv($line);
        }
        array_shift($result);
        array_pop($result);

        return $result;
    }
}
