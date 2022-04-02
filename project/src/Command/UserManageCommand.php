<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UserManageCommand extends Command
{
    protected function configure()
    {
        $this->setName('user:crud:create');
        $this->setDescription('Create user');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        return;
    }
}
