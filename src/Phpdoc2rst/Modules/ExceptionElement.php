<?php
/**
 * Created by JetBrains PhpStorm.
 * User: victor
 * Date: 03.05.13
 * Time: 8:46
 */

namespace Phpdoc2rst\Modules;


class ExceptionElement extends \Phpdoc2rst\Element\ExceptionElement
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