<?php
/**
 * Created by JetBrains PhpStorm.
 * User: victor
 * Date: 03.05.13
 * Time: 8:36
 */

namespace Phpdoc2rst\Modules;

require_once __DIR__.'/../../../../trains/app/Autoload.php';

class TrainSystemConnector
{
    /**
     * @return ExceptionElement[]
     */
    public function getAdditionalExceptions()
    {
        /** @var \Art\Services\Ufs\ErrorsService $errorsService */
        $errorsService = \Art\ClassFactory::GetInstance('Art\\Services\\Ufs\\ErrorsService');

        $errors = $errorsService->getActiveErrorMessages();

        $exceptions = [];

        foreach($errors as $error)
        {
            $exceptions[] = new ExceptionElement($error->getId(), $error->getDescriptionEn());
        }

        return $exceptions;
    }
}