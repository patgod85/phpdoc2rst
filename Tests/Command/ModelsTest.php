<?php

namespace Patgod85\Phpdoc2rst\Tests\Command;


use Patgod85\Phpdoc2rst\Command\ProcessCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class ModelsTest extends CommandHelper
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
            'namespace' => 'input\Models',
            'path' => self::INPUT_RELATIVE_PATH.'/Models',
            '-o' => self::OUTPUT_RELATIVE_PATH.'/Models',
            '--target' => 'properties',
            '-x' => 'input\Models\Excluded',
        ));

        $inputPath = self::INPUT_RELATIVE_PATH;
        $outputPath = realpath($this->getOutputPath());

        $expected = <<<eot
Processing code from namespace input\Models
Processing files from $inputPath/Models
Outputting to {$outputPath}\Models
Processing input\Models

eot;

        $this->assertEquals(
            $expected,
            $commandTester->getDisplay(),
            'Output of command in unexpected'
        );

        $this->assertEquals(
            file_get_contents($this->getExpectedPath().'/Models/Person.rst'),
            file_get_contents($this->getOutputPath().'/Models/Person.rst'),
            'Content of Person.rst file is unexpected'
        );

        $this->assertFalse(
            file_exists($this->getOutputPath().'/Models/Excluded.rst'),
            'File of ExcludedController found'
        );

    }

    public function testGroups()
    {
        $application = new Application();
        $application->add(new ProcessCommand());

        $command = $application->find('phpdoc2rst:process');
        /** @noinspection PhpUndefinedMethodInspection */
        $command->setContainer($this->getContainer());
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'namespace' => 'input\Models',
            'path' => self::INPUT_RELATIVE_PATH.'/Models',
            '-o' => self::OUTPUT_RELATIVE_PATH.'/Models',
            '--target' => 'properties',
            '-x' => 'input\Models\Excluded',
            '--groups' => '[Export,Json]',
        ));

        $inputPath = self::INPUT_RELATIVE_PATH;
        $outputPath = realpath($this->getOutputPath());

        $expected = <<<eot
Processing code from namespace input\Models
Processing files from $inputPath/Models
Outputting to {$outputPath}\Models
Processing input\Models

eot;

        $this->assertEquals(
            $expected,
            $commandTester->getDisplay(),
            'Output of command in unexpected'
        );

        $this->assertEquals(
            file_get_contents($this->getExpectedPath().'/Models/Order.rst'),
            file_get_contents($this->getOutputPath().'/Models/Order.rst'),
            'Content of Order.rst file is unexpected'
        );

        $this->assertFalse(
            file_exists($this->getOutputPath().'/Models/Excluded.rst'),
            'File of ExcludedController found'
        );

    }
}
