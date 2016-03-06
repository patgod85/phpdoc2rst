<?php

namespace Patgod85\Phpdoc2rst\Tests\Command;


use Patgod85\Phpdoc2rst\Annotation\Exclude;
use Patgod85\Phpdoc2rst\Annotation\HttpMethod;
use Patgod85\Phpdoc2rst\Command\ProcessCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class PositiveTest extends \PHPUnit_Framework_TestCase
{
    public function testNameIsOutput()
    {
        new Exclude();
        new HttpMethod();

        $application = new Application();
        $application->add(new ProcessCommand());

        $command = $application->find('phpdoc2rst:process');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'namespace' => 'input\Controller',
            'path' => '../../Resources/test/input/Controllers',
            '-o' => '../../Resources/test/output/Controllers',
            '-e' => 'methods',
        ));

        $expected = <<<eot
Processing code from namespace input\Controller
Processing files from ../../Resources/test/input/Controllers
Outputting to C:\\repos\git\phpdoc2rst\Resources\\test\output\Controllers
Processing input\Controllers

eot;

        $this->assertEquals($expected, $commandTester->getDisplay());


        $this->assertEquals(
            file_get_contents(__DIR__.'/../../Resources/test/expected/Controllers/TicketsController.rst'),
            file_get_contents(__DIR__.'/../../Resources/test/output/Controllers/TicketsController.rst')
        );
    }
}
