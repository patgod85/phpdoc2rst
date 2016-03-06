<?php

namespace Patgod85\Phpdoc2rst\Tests;


use Patgod85\Phpdoc2rst\Annotation\Exclude;
use Patgod85\Phpdoc2rst\Annotation\HttpMethod;
use Patgod85\Phpdoc2rst\Command\Process;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class PositiveTest extends \PHPUnit_Framework_TestCase
{
    public function testNameIsOutput()
    {
        new Exclude();
        new HttpMethod();

        $application = new Application();
        $application->add(new Process());

        $command = $application->find('process');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'namespace' => 'input\Controller',
            'path' => './input/Controllers',
            '-o' => './output/Controllers',
            '-e' => 'methods',
        ));

        $expected = <<<eot
Processing code from namespace input\Controller
Processing files from ./input/Controllers
Outputting to C:\\repos\git\phpdoc2rst\Tests\output\Controllers
Processing input\Controllers

eot;

        $this->assertEquals($expected, $commandTester->getDisplay());


        $this->assertEquals(
            file_get_contents(__DIR__.'/expected/Controllers/TicketsController.rst'),
            file_get_contents(__DIR__.'/output/Controllers/TicketsController.rst')
        );
    }
}
