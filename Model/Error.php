<?php

namespace Patgod85\Phpdoc2rst\Model;


class Error implements IError
{
    private $id;

    private $descriptionEn;

    /**
     * Error constructor.
     * @param $id
     * @param $descriptionEn
     */
    public function __construct($id, $descriptionEn)
    {
        $this->id = $id;
        $this->descriptionEn = $descriptionEn;
    }


    public function getId()
    {
        return $this->id;
    }

    public function getDescriptionEn()
    {
        return $this->descriptionEn;
    }

}