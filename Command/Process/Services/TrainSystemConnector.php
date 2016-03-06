<?php

namespace Patgod85\Phpdoc2rst\Command\Process\Services;

use Patgod85\Phpdoc2rst\Command\Process\Element\ExceptionFromDbElement;

require_once __DIR__.'/../../../../trains/app/Autoload.php';

class TrainSystemConnector
{
    /**
     * @return ExceptionFromDbElement[]
     */
    public function getAdditionalExceptions()
    {
        return [];
//        TODO: get Exceptions from DB
//        /** @var \Rr\UfsBundle\Service $errorsService */
//        $errorsService = \Art\ClassFactory::GetInstance('Art\\Services\\Ufs\\ErrorsService');
//
//        $errors = $errorsService->getActiveErrorMessages();
//
//        $exceptions = [];
//
//        foreach($errors as $error)
//        {
//            $exceptions[] = new ExceptionFromDbElement($error->getId(), $error->getDescriptionEn());
//        }
//
//        return $exceptions;
    }
}