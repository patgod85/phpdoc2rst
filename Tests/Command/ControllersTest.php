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
            'path' => $this->getInputPath().'/Controllers',
            '-o' => $this->getOutputPath().'/Controllers',
            '--target' => 'methods',
        ));

        $inputPath = $this->getInputPath();
        $outputPath = realpath($this->getOutputPath());

        $expected = <<<eot
Processing code from namespace input\Controller
Processing files from $inputPath/Controllers
Outputting to {$outputPath}\Controllers
Processing input\Controllers

eot;

        $this->assertEquals(
            $expected,
            $commandTester->getDisplay(),
            'Output of command in unexpected'
        );

		$expected = $this->replaceBreakLines(file_get_contents($this->getExpectedPath().'/Controllers/TicketsController.rst'));
		$actual = $this->replaceBreakLines(file_get_contents($this->getOutputPath().'/Controllers/TicketsController.rst'));

        $this->assertEquals(
            $expected,
            $actual,
            'Content of result file is unexpected'
        );


        $this->assertFalse(
            file_exists($this->getOutputPath().'/Controllers/ExcludedController.rst'),
            'File of ExcludedController found'
        );
    }

}
