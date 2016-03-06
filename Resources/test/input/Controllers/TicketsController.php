<?php

namespace input\Controllers;

use Patgod85\Phpdoc2rst\Annotation as P2R;

/**
 * Path:
 *
 * ``/tickets/[_methodName_]``
 *
 * Provides methods for booking, confirming, declining, cancelling and editing tickets, as well as changing the registration type.
 */
class TicketsController
{
    protected $controllerPath = '/xml/bookTicket';

    /**
     * @param $method
     * @return array
     * @P2R\Exclude
     */
    protected function getAppService($method)
    {
    }

    /**
     * The method for booking of several request in one time
     *
     * Parameters:
     *
     * * params - Contain XML with tickets details. See `Model <../models/request/BookPackage.rst>`_ specification
     *
     * Example of request:
     *
     * ``/tickets/bookPackage``
     *
     * Result: `BookPackageResult <../models/response/BookPackageResult.rst>`_
     * @P2R\HttpMethod("POST")
     * @param int $appService
     * @param int $request
     * @return string
     */
    protected function bookPackage($appService, $request)
    {
        return "valid result".$appService.$request;
    }
}

