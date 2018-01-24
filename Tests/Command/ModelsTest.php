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
            'path' => $this->getInputPath().'/Models',
            '-o' => $this->getOutputPath().'/Models',
            '--target' => 'properties',
            '-x' => 'input\Models\Excluded',
        ));

        $inputPath = $this->getInputPath();
        $outputPath = realpath($this->getOutputPath());

        $expected = <<<eot
Processing code from namespace input\Models
Processing files from $inputPath/Models
Outputting to {$outputPath}\Models
Processing input\Models

eot;

        $this->assertEquals(
            $expected,
            preg_replace('/.\[3\dm/', '', $commandTester->getDisplay()),
            'Output of command in unexpected'
        );

        $this->assertEquals(
            $this->replaceBreakLines(file_get_contents($this->getExpectedPath().'/Models/Person.rst')),
            $this->replaceBreakLines(file_get_contents($this->getOutputPath().'/Models/Person.rst')),
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
            'path' => $this->getInputPath().'/Models',
            '-o' => $this->getOutputPath().'/Models',
            '--target' => 'properties',
            '-x' => 'input\Models\Excluded',
            '--groups' => '[Export,Json]',
        ));

        $inputPath = $this->getInputPath();
        $outputPath = realpath($this->getOutputPath());

        $expected = <<<eot
Processing code from namespace input\Models
Processing files from $inputPath/Models
Outputting to {$outputPath}\Models
Processing input\Models

eot;

        $this->assertEquals(
            $expected,
            preg_replace('/.\[3\dm/', '', $commandTester->getDisplay()),
            'Output of command in unexpected'
        );

        $this->assertEquals(
            $this->replaceBreakLines(file_get_contents($this->getExpectedPath().'/Models/Order.rst')),
            $this->replaceBreakLines(file_get_contents($this->getOutputPath().'/Models/Order.rst')),
            'Content of Order.rst file is unexpected'
        );

        $this->assertFalse(
            file_exists($this->getOutputPath().'/Models/Excluded.rst'),
            'File of ExcludedController found'
        );

    }

    public function testHeader()
    {
        $application = new Application();
        $application->add(new ProcessCommand());

        $command = $application->find('phpdoc2rst:process');
        /** @noinspection PhpUndefinedMethodInspection */
        $command->setContainer($this->getContainer());
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'namespace' => 'input\Models',
            'path' => $this->getInputPath().'/Models',
            '-o' => $this->getOutputPath().'/Models',
            '--target' => 'properties',
            '-x' => 'input\Models\Excluded',
            '--header' => 'h2',
        ));

        $inputPath = $this->getInputPath();
        $outputPath = realpath($this->getOutputPath());

        $expected = <<<eot
Processing code from namespace input\Models
Processing files from $inputPath/Models
Outputting to {$outputPath}\Models
Processing input\Models

eot;

        $this->assertEquals(
            $expected,
            preg_replace('/.\[3\dm/', '', $commandTester->getDisplay()),
            'Output of command in unexpected'
        );

        $this->assertEquals(
            $this->replaceBreakLines(file_get_contents($this->getExpectedPath().'/Models/Owner.rst')),
            $this->replaceBreakLines(file_get_contents($this->getOutputPath().'/Models/Owner.rst')),
            'Content of Owner.rst file is unexpected'
        );

    }
}
