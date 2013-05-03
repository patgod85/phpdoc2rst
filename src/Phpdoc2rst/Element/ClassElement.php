<?php

namespace Phpdoc2rst\Element;

use TokenReflection\ReflectionClass;

use Symfony\Component\Console\Output\OutputInterface;


/**
 * Class element
 */
class ClassElement extends Element
{
    /**
     * @var ReflectionClass
     */
    protected $reflection;

    private $elementsForOutput;

    /**
     * Constructor
     *
     * @param \TokenReflection\ReflectionClass $reflection
     * @internal param string $classname
     */
    public function __construct(ReflectionClass $reflection)
    {
        parent::__construct($reflection);
    }

    public function getPath()
    {
        return $this->reflection->getShortName() . '.rst';
    }

    /**
     * @param string $basedir
     * @param OutputInterface $output
     * @param string $elementsForOutput
     * @return void
     */
    public function build($basedir, OutputInterface $output, $elementsForOutput)
    {
        $this->elementsForOutput = $elementsForOutput;

        $file = $basedir . DIRECTORY_SEPARATOR . $this->getPath();
        file_put_contents($file, $this->__toString());
    }

    public function getName()
    {
        return $this->reflection->getShortName();
    }

    public function getDescription()
    {
        $parser = $this->getParser();

        return $parser->getDescription();
    }

    /**
     * @see Phpdoc2rst\Element.Element::__toString()
     */
    public function __toString()
    {
        $name = $this->reflection->getName();

        $string = "====\n".$this->reflection->getShortName()."\n====";

        $parser = $this->getParser();

        if ($description = $parser->getDescription())
        {
            $string .= "\n\n";
            $string .= $description;
        }

        foreach ($this->getSubElements() as $element)
        {
            $e = $element->__toString();
            if ($e)
            {
                $string .= "\n\n";
                $string .= $e;
            }
        }

        $string .= "\n\n";

        // Finally, fix some whitespace errors
        $string = preg_replace('/^\s+$/m', '', $string);
        $string = preg_replace('/ +$/m', '', $string);

        return $string;
    }

    protected function getSubElements()
    {
        switch($this->elementsForOutput)
        {
            case 'methods':
                return $this->getMethods();
            case 'properties':
                return $this->getProperties();
        }

        return [];
    }

    protected function getConstants()
    {
        return array_map(function ($v) {
            return new ConstantElement($v);
        }, $this->reflection->getConstantReflections());
    }

    public function getProperties()
    {
        return array_map(function ($v) {
            return new PropertyElement($v);
        }, $this->reflection->getProperties());
    }

    public function getMethods()
    {
        return array_map(function ($v) {
            return new MethodElement($v);
        }, $this->reflection->getOwnMethods());
    }

    public function getNamespaceElement()
    {
        return '.. php:namespace: '
            . str_replace('\\', '\\\\', $this->reflection->getNamespaceName())
            . "\n\n";
    }
}