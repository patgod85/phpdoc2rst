====
TicketsController
====

Path:

``/tickets/[_methodName_]``

Provides methods for booking, confirming, declining, cancelling and editing tickets, as well as changing the registration type.




.. _bookPackage:
bookPackage
----
Method: GET

The method for booking of several request in one time

Parameters:

* params - Contain XML with tickets details. See `Model <../models/request/BookPackage.rst>`_ specification

Example of request:

``/tickets/bookPackage``

Method: POST Result: `BookPackageResult <../models/response/BookPackageResult.rst>`_

