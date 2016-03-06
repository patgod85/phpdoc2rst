<?php

namespace Phpdoc2rst\Element;

use Phpdoc2rst\CommentParser;
use TokenReflection\IReflection;

/**
 * Represents a code element that can be documented with PHPDoc/Sphinx
 */
abstract class Element
{
    /** @var IReflection  */
    protected $reflection;

    /**
     * Constructor
     *
     * @param IReflection $reflection
     */
    public function __construct(IReflection $reflection)
    {
        $this->reflection = $reflection;
    }

    /**
     */
    protected function getParser()
    {
        return new CommentParser($this->reflection->getDocComment());
    }


    /**
     * Indents the given lines
     *
     * @param string $output
     * @param int $spaces
     * @param bool $rewrap
     * @return mixed|string
     */
    protected function indent($output, $spaces = 3, $rewrap = false)
    {
        if (!$output) {
            return '';
        }

        $line = 78;
        $spaces = str_pad(' ', $spaces);

        if ($rewrap) {
            if (preg_match('/^( +)/', $output, $matches)) {
                $spaces .= $matches[1];
            }
            $output = preg_replace('/^ +/m', '', $output);
            $output = wordwrap($output, $line - strlen($spaces));
        }

        $output = preg_replace('/^/m', $spaces, $output);

        return $output;
    }
}