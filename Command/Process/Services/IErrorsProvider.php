<?php

namespace Patgod85\Phpdoc2rst\Command\Process\Services;

use Patgod85\Phpdoc2rst\Model\IError;

interface IErrorsProvider
{
    /**
     * @return IError[]
     */
    public function getActiveErrorMessages();
}