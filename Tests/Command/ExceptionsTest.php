<?php

namespace Patgod85\Phpdoc2rst\Tests\Command;


use Patgod85\Phpdoc2rst\Command\ProcessCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class ExceptionsTest extends CommandHelper
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
            'namespace' => 'input\Exceptions',
            'path' => self::INPUT_RELATIVE_PATH.'/Exceptions',
            '-o' => self::OUTPUT_RELATIVE_PATH.'/Exceptions',
            '--target' => 'exceptions',
        ));

        $inputPath = self::INPUT_RELATIVE_PATH;
        $outputPath = realpath($this->getOutputPath());

        $expected = <<<eot
Processing code from namespace input\Exceptions
Processing files from $inputPath/Exceptions
Outputting to {$outputPath}\Exceptions
Processing input\Exceptions

eot;

        $this->assertEquals(
            $expected,
            $commandTester->getDisplay(),
            'Output of command in unexpected'
        );

        $this->assertEquals(
            file_get_contents($this->getExpectedPath().'/Exceptions/errors.rst'),
            file_get_contents($this->getOutputPath().'/Exceptions/errors.rst'),
            'Content of result file is unexpected'
        );

    }

}
