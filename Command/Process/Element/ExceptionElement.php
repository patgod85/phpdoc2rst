<?php
/**
 * Created by JetBrains PhpStorm.
 * User: victor
 * Date: 11.03.13
 * Time: 14:47
 * To change this template use File | Settings | File Templates.
 */

namespace Patgod85\Phpdoc2rst\Command\Process\Element;


class ExceptionElement extends ClassElement
{
    public function getCode()
    {
        $fileName = $this->reflection->getFileName();

        preg_match('/E(\d+)[^\d]+.+/', $fileName, $match);

        if(count($match) != 2)
        {
            throw new \Exception('Error of parsing of exception file name');
        }

        return $match[1];
    }

    public function getDescription()
    {
        return $this->reflection->getProperty('publicMessage')->getDefaultValue();
    }
}