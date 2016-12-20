<?php

namespace Patgod85\Phpdoc2rst\Command\Process\Element;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Inflector\Inflector;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Groups;
use Patgod85\Phpdoc2rst\Command\Process\CommentParser;
use TokenReflection\IReflectionProperty;
use TokenReflection\IReflection;

/**
 * Property element
 */
class PropertyElement extends Element
{
    /** @var IReflectionProperty  */
    protected $reflection;

    /** @var  bool */
    private $isExcluded;

    /** @var  array */
    private $groups;

    /**
     * PropertyElement constructor.
     */
    public function __construct(IReflection $reflection)
    {
        parent::__construct($reflection);


        $this->readAnnotations();
    }


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
        return $this->isExcluded;
    }

    private function readAnnotations()
    {
        $reader = new AnnotationReader();

        $doctrineAnnotations = $reader->getPropertyAnnotations(
            new \ReflectionProperty(
                $this->reflection->getDeclaringClassName(),
                Inflector::camelize($this->getName())
            )
        );

        $this->isExcluded = false;

        foreach($doctrineAnnotations as $annotation)
        {
            if($annotation instanceof Exclude)
            {
                $this->isExcluded = true;
            }
            elseif($annotation instanceof Groups)
            {
                $this->groups = $annotation->groups;
            }
        }

        return false;
    }

    public function getGroups()
    {
        return $this->groups;
    }

    protected function getParser()
    {
        return new CommentParser($this->reflection->getDocComment());
    }
}