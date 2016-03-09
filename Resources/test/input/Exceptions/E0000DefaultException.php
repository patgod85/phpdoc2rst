<?php

namespace input\Exceptions;

class E0000DefaultException extends \Exception
{
    /**
     * @var string
     */
    protected $publicMessage;

    /**
     * @var string
     */
    protected $details;

    public function __construct($details = '', \Exception $previous = null)
    {
        $this->details = $details;

        $code = 0;

        parent::__construct($this->publicMessage, $code, $previous);
    }

    /**
     * @return string
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @return string
     */
    public function getPublicMessage()
    {
        return $this->publicMessage;
    }


}
