<?php

namespace Patgod85\Phpdoc2rst\Command\Process\Element;
use TokenReflection\ReflectionProperty;

/**
 * Property element
 */
class StaticPropertyElement extends Element
{
    /** @var  ReflectionProperty */
    protected $reflection;

    protected function getDescription()
    {
        return $this->reflection->getDocComment();
    }

    public function __toString()
    {
        return $this->indent($this->getDescription(), 4) . "\n";
    }
}