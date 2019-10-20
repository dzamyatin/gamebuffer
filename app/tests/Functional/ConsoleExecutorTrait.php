<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpKernel\KernelInterface;

trait ConsoleExecutorTrait
{
    protected function commandExcecute(ArrayInput $input, KernelInterface $kernel): BufferedOutput
    {
        $application = new Application($kernel);
        $application->setAutoExit(false);
        $output = new BufferedOutput();
        $application->run($input, $output);
        return $output;
    }
}