<?php

namespace App\Command;

use App\Manager\MergeManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class GamebufferProcessCommand extends Command
{

    const TIME_TO_WAIT = 10;

    private $mergeManager;

    public function __construct(
        string $name = 'gamebuffer:process',
        MergeManager $mergeManager
    ) {
        parent::__construct($name);
        $this->mergeManager = $mergeManager;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $io->note('Start process');

        while (true) {
            $time = time();
            $this->mergeManager->process();
            $time = $time + self::TIME_TO_WAIT - time();
            sleep($time < 0 ? 0 : $time);
        }

        $io->success('Success process');
    }
}
