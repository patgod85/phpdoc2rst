<?php

namespace Patgod85\Phpdoc2rst\Command\Process\Element;


class ExceptionFromDbElement
{
    private $code;

    private $description;

    function __construct($code, $description)
    {
        $this->code = $code;
        $this->description = $description;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getCode()
    {
        return $this->code;
    }
}