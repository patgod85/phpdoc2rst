<?php

namespace Phpdoc2rst\Tests;

use Phpdoc2rst\Process;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class PositiveTest extends \PHPUnit_Framework_TestCase
{
    public function testNameIsOutput()
    {
        $application = new Application();
        $application->add(new Process());

        $command = $application->find('process');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'namespace' => 'Rr\GatewayBundle\Controller',
            'path' => './input/Controllers',
            '-o' => './output/Controllers',
            '-e' => 'methods',
        ));

        $expected = <<<eot
Processing code from namespace Rr\GatewayBundle\Controller
Processing files from ./input/Controllers
Outputting to C:\\repos\git\phpdoc2rst\src\Phpdoc2rst\Tests\output\Controllers
Processing Rr\GatewayBundle\Controller

eot;

        $this->assertEquals($expected, $commandTester->getDisplay());


        $this->assertEquals(
            file_get_contents(__DIR__.'/expected/Controllers/TicketsController.rst'),
            file_get_contents(__DIR__.'/output/Controllers/TicketsController.rst')
        );
    }
}
