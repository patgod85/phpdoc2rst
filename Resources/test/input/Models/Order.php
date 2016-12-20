<?php

namespace input\Models;

use Patgod85\Phpdoc2rst\Annotation as P2R;
use JMS\Serializer\Annotation as Serializer;

/**
 */
class Order
{
    /**
     * @var Person
     * @Serializer\Groups({"Export"})
     *
     */
    private $passengers;

    /**
     * @var string
     */
    private $innerData;

    /**
     * @var string
     */
    private $innerData2;

    /**
     * @return Person
     */
    public function getPassengers()
    {
        return $this->passengers;
    }

    /**
     * @return string
     */
    public function getInnerData()
    {
        return $this->innerData;
    }

    /**
     * @return string
     */
    public function getInnerData2()
    {
        return $this->innerData2;
    }


}
