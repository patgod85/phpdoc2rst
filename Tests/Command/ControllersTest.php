<?php

namespace Patgod85\Phpdoc2rst\Tests\Command;


use Patgod85\Phpdoc2rst\Annotation\Exclude;
use Patgod85\Phpdoc2rst\Annotation\HttpMethod;
use Patgod85\Phpdoc2rst\Annotation\Result;
use Patgod85\Phpdoc2rst\Command\ProcessCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class ControllersTest extends CommandHelper
{
    public function setUp()
    {
        $Directory = new \RecursiveDirectoryIterator($this->getOutputPath());
        $Iterator = new \RecursiveIteratorIterator($Directory);
        $Regex = new \RegexIterator($Iterator, '/^.+\.rst$/i', \RecursiveRegexIterator::GET_MATCH);

        foreach($Regex as $item)
        {
            unlink($item[0]);
            print_r('A file removed before a test: '.$item[0]."\n");
        }
    }

    public function testNameIsOutput()
    {
        new Exclude();
        new HttpMethod();
        new Result();

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
