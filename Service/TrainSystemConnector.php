<?php

namespace Patgod85\Phpdoc2rst\Service;

use Patgod85\Phpdoc2rst\Command\Process\Element\ExceptionFromDbElement;
use Patgod85\Phpdoc2rst\Command\Process\Services\IErrorsProvider;

class TrainSystemConnector
{
    /** @var IErrorsProvider  */
    private $errorsProvider;

    function __construct(IErrorsProvider $errorsProvider)
    {
        $this->errorsProvider = $errorsProvider;
    }
    /**
     * @return ExceptionFromDbElement[]
     */
    public function getAdditionalExceptions()
    {
        $errors = $this->errorsProvider->getActiveErrorMessages();

        $exceptions = [];

        foreach($errors as $error)
        {
            $exceptions[] = new ExceptionFromDbElement($error->getId(), $error->getDescriptionEn());
        }

        return $exceptions;
    }
}