<?php

namespace Patgod85\Phpdoc2rst\Command\Process\Element;

use Patgod85\Phpdoc2rst\Command\Process\CommentParser;
use TokenReflection\IReflectionConstant;

/**
 * Constant element
 */
class ConstantElement extends Element
{
    /** @var IReflectionConstant  */
    protected $reflection;

    public function __construct(IReflectionConstant $constant)
    {
        parent::__construct($constant);
    }

    /**
     * @see Patgod85\Phpdoc2rst\Command\Process\Element.Element::__toString()
     */
    public function __toString()
    {
        $string = '';

        if ($this->reflection->getDocComment()) {
            $string = sprintf(".. php:const:: %s\n\n", $this->reflection->getName());

            $parser = $this->getParser();
            if ($parser->hasDescription()) {
                $description = $parser->getDescription();
                if ($description) {
                    $string .= "\n\n";
                    $string .= $this->indent($description, 4);
                }
            }
        }

        return $string;
    }

    protected function getParser()
    {
        return new CommentParser($this->reflection->getDocComment());
    }
}