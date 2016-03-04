<?php

namespace Rr\GatewayBundle\Controller;

use Rr\GatewayBundle\Service\App\Tickets as appServices;
use Rr\GatewayBundle\Service\App\GatewayApp;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     * Method: POST
     * Result: `BookPackageResult <../models/response/BookPackageResult.rst>`_
     * @param appServices\BookPackage $appService
     * @param Request $request
     * @return string
     */
    protected function bookPackage(appServices\BookPackage $appService, Request $request)
    {
        return $appService->execute($request->get('params'));
    }
}

$a = new TicketsController();
