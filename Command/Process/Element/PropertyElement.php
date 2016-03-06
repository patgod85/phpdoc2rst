<?php

namespace Patgod85\Phpdoc2rst\Command\Process\Element;

use Doctrine\Common\Inflector\Inflector;
use Patgod85\Phpdoc2rst\Command\Process\CommentParser;
use TokenReflection\IReflectionProperty;

/**
 * Property element
 */
class PropertyElement extends Element
{
    /** @var IReflectionProperty  */
    protected $reflection;


    public function getDescription()
    {
        $parser = $this->getParser();

        return $parser->getDescription();
    }

    public function getName()
    {
        $name = $this->reflection->getName();

        $inflector = new Inflector();

        $name = $inflector->tableize($name);

        return $name;
    }

    public function getType()
    {
        $vars = $this->getParser()->getAnnotationsByName('var');
        $var = count($vars) ? array_pop($vars) : false;
        $parts = preg_split('/\s+/', $var);

        $type = 'string';

        if (count($parts) >= 2) {
            if ($parts[1]) {
                $type =  $parts[1];
            }
        }

        if(strpos($type, '[]') !== false)
        {
            $arrayMarker = '\[]';
        }
        else
        {
            $arrayMarker = '';
        }

        $type = str_replace('[]', '', $type);

        if(!in_array($type, ['int', 'float', 'double', 'string', 'bool']))
        {
            $type = "`$type <$type.rst>`_";
        }

        $type .= $arrayMarker;

        return $type;
    }

    public function isExcluded()
    {
        $serializer = $this->getParser()->getAnnotationsByName('Serializer');

        foreach($serializer as $annotation)
        {
            if(strpos($annotation, 'Exclude') !== false)
            {
                return true;
            }
        }

        return false;
    }

    protected function getParser()
    {
        return new CommentParser($this->reflection->getDocComment());
    }
}