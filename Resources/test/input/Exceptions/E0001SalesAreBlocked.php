<?php

namespace input\Exceptions;


class E0001SalesAreBlocked extends E0000DefaultException
{
    protected $publicMessage = 'Sales and other requests are blocked';
}