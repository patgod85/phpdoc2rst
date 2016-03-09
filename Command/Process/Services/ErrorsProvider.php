<?php

namespace Patgod85\Phpdoc2rst\Command\Process\Services;

class ErrorsProvider implements IErrorsProvider
{
    public function getActiveErrorMessages()
    {
        return [];
    }

}