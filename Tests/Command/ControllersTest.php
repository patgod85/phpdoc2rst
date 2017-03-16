<?php

namespace Patgod85\Phpdoc2rst\Tests\Command;


use Patgod85\Phpdoc2rst\Command\ProcessCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class ControllersTest extends CommandHelper
{
    public function testNameIsOutput()
    {
        $application = new Application();
        $application->add(new ProcessCommand());

        $command = $application->find('phpdoc2rst:process');
        /** @noinspection PhpUndefinedMethodInspection */
        $command->setContainer($this->getContainer());
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'namespace' => 'input\Controller',
            'path' => self::INPUT_RELATIVE_PATH.'/Controllers',
            '-o' => self::OUTPUT_RELATIVE_PATH.'/Controllers',
            '--target' => 'methods',
        ));

        $inputPath = self::INPUT_RELATIVE_PATH;
        $outputPath = realpath($this->getOutputPath());

        $expected = <<<eot
\033[33mProcessing code from namespace input\Controller\033[39m
\033[33mProcessing files from $inputPath/Controllers\033[39m
\033[33mOutputting to {$outputPath}\Controllers\033[39m
\033[32mProcessing input\Controllers\033[39m

eot;

        $this->assertEquals(
            $expected,
            $commandTester->getDisplay(),
            'Output of command in unexpected'
        );

        $this->assertEquals(
            file_get_contents($this->getExpectedPath().'/Controllers/TicketsController.rst'),
            file_get_contents($this->getOutputPath().'/Controllers/TicketsController.rst'),
            'Content of result file is unexpected'
        );


        $this->assertFalse(
            file_exists($this->getOutputPath().'/Controllers/ExcludedController.rst'),
            'File of ExcludedController found'
        );
    }

}
