<?php

namespace Patgod85\Phpdoc2rst\Model;

interface IError
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getDescriptionEn();
}