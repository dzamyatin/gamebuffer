<?php

namespace App\Tests\Functional\Manager;

use App\Manager\MergeManager;
use App\Tests\Functional\ConsoleExecutorTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Input\ArrayInput;

class MergeManagerTest extends KernelTestCase
{
    use ConsoleExecutorTrait;

    public function setUp(): void
    {
        static::bootKernel();

        $output = $this->commandExcecute(new ArrayInput([
            'command' => 'doctrine:database:create',
            '--if-not-exists' => true,
            '--no-interaction' => true,
        ]), static::$kernel);
        echo $output->fetch();

        $this->commandExcecute(new ArrayInput([
            'command' => 'doctrine:migration:migrate',
            '--no-interaction' => true,
        ]), static::$kernel);
        echo $output->fetch();

        $this->commandExcecute(new ArrayInput([
            'command' => 'doctrine:fixtures:load',
            '--no-interaction' => true,
        ]), static::$kernel);
        echo $output->fetch();
    }

    public function tearDown(): void
    {
        $output = $this->commandExcecute(new ArrayInput([
            'command' => 'doctrine:database:drop',
            '--force' => true,
            '--if-exists' => true,
            '--no-interaction' => true,
        ]), static::$kernel);

        echo $output->fetch();
    }

    public function testProcess()
    {
        /** @var MergeManager $mergeManager */
        $mergeManager = static::$container->get(MergeManager::class);
        $mergeManager->process();
        //@TODO here should be some assert
    }
}