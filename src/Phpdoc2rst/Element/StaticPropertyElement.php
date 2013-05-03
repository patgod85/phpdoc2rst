<?php

namespace Phpdoc2rst\Element;

use Symfony\Component\Console\Output\OutputInterface;

/**
 * Property element
 */
class StaticPropertyElement extends Element
{
    protected function getDescription()
    {
        return $this->reflection->getDocComment();
    }

    public function __toString()
    {
        return $this->indent($this->getDescription(), 4) . "\n";
    }
}