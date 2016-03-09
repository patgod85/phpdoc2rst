<?php

namespace Patgod85\Phpdoc2rst\Tests\Command;

use Mockery as m;
use Patgod85\Phpdoc2rst\Command\Process\Services\ErrorsProvider;
use Patgod85\Phpdoc2rst\Service\TrainSystemConnector;
use Symfony\Component\DependencyInjection\Container;

class CommandHelper extends \PHPUnit_Framework_TestCase
{
    const INPUT_RELATIVE_PATH = '../../Resources/test/input';
    const OUTPUT_RELATIVE_PATH = '../../Resources/test/output';
    const EXPECTED_RELATIVE_PATH = '../../Resources/test/expected';

    /**
     * @return Container
     */
    protected function getContainer()
    {
        $errorsProvider = new ErrorsProvider();

        $trainSystemConnector = new TrainSystemConnector($errorsProvider);

        $container = m::mock('Symfony\Component\DependencyInjection\Container');
        /** @noinspection PhpMethodParametersCountMismatchInspection */
        $container
            ->shouldReceive('get')
            ->once()
            ->with('phpdoc2rst_train_system_connector')
            ->andReturn($trainSystemConnector)
        ;

        return $container;
    }

    protected function getInputPath()
    {
        return __DIR__.'/'.self::INPUT_RELATIVE_PATH;
    }

    protected function getOutputPath()
    {
        return __DIR__.'/'.self::OUTPUT_RELATIVE_PATH;
    }
    protected function getExpectedPath()
    {
        return __DIR__.'/'.self::EXPECTED_RELATIVE_PATH;
    }
}