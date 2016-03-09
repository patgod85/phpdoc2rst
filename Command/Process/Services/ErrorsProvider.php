<?php

namespace Patgod85\Phpdoc2rst\Command\Process\Services;
use Patgod85\Phpdoc2rst\Model\Error;

/**
 * !!! Class for MOCK purposes only !!!
 */
class ErrorsProvider implements IErrorsProvider
{
    public function getActiveErrorMessages()
    {
        return [
            new Error(100, 'The first error from database'),
            new Error(101, 'The second error from database'),
        ];
    }

}