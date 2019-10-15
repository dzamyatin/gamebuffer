<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class GamebufferProcessCommand extends Command
{
    protected static $defaultName = 'gamebuffer:process';

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $io->note('Start process');

        while (true) {
            //@TODO process
        }

        $io->success('Success process');
    }
}
