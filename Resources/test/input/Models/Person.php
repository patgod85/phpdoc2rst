<?php

namespace input\Models;


/**
 */
class Person
{
    /**
     * @var int
     */
    private $documentTypeId;

    /**
     * @var string
     */
    private $documentNumber;

    /**
     * @var string
     */
    private $name;


    /**
     * @var string
     */
    private $birthDate;

    function __construct($documentTypeId, $documentNumber, $name, $birthDate)
    {
        $this->documentTypeId = $documentTypeId;
        $this->documentNumber = $documentNumber;
        $this->name = $name;
        $this->birthDate = $birthDate;
    }

}
