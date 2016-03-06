<?php

namespace Patgod85\Phpdoc2rst\Command\Process\Element;

use Doctrine\Common\Annotations\AnnotationReader;
use Patgod85\Phpdoc2rst\Annotation\Exclude;
use Patgod85\Phpdoc2rst\Annotation\HttpMethod;
use Patgod85\Phpdoc2rst\Command\Process\CommentParser;
use TokenReflection\Exception\RuntimeException;
use TokenReflection\IReflectionMethod;
use TokenReflection\ReflectionParameter;

/**
 * Method element
 */
class MethodElement extends Element
{
    private $name;

    private $httpMethod;

    /** @var  IReflectionMethod */
    protected $reflection;

    /** @var array  */
    protected $doctrineAnnotations;

    /**
     * Constructor
     *
     * @param IReflectionMethod $method
     */
    public function __construct(IReflectionMethod $method)
    {
        parent::__construct($method);

        $methodName = $this->reflection->getName();

        $reader = new AnnotationReader();
        $this->doctrineAnnotations = $reader->getMethodAnnotations(new \ReflectionMethod($this->reflection->getDeclaringClassName(), $methodName));

        list($this->name, $this->httpMethod) = $this->processMethodName($methodName);
    }

    /**
     * Gets an array of simplified information about the parameters of this
     * method
     *
     * @return array
     */
    protected function getParameterInfo()
    {
        $params = array();

        $parameters = $this->reflection->getParameters();

        /** @var ReflectionParameter $parameter */
        foreach ($parameters as $parameter) {
            $params[$parameter->getName()] = array(
                'name'      => $parameter->getName(),
                'hint_type' => $parameter->getOriginalTypeHint(),
                'type'      => $parameter->getOriginalTypeHint(),
                'comment'   => null
            );

            if ($parameter->isDefaultValueAvailable()) {
                try {
                    $params[$parameter->getName()]['default'] = trim($parameter->getDefaultValueDefinition());
                } catch (RuntimeException $e) {
                    // Just don't provide a default
                }
            }
        }

        $annotations = array_filter($this->getParser()->getAnnotations(), function ($v) {
            $e = explode(' ', $v);
            return isset($e[0]) && $e[0] == '@param';
        });
        foreach ($annotations as $parameter) {
            $parts = explode(' ', $parameter);

            if (count($parts) < 3) {
                continue;
            }

            $type = trim($parts[1]);
            $name = trim(str_replace('$', '', $parts[2]));
            $comment = trim(implode(' ', array_slice($parts, 3)));

            if (isset($params[$name])) {
                if ($params[$name]['type'] == null && $type) {
                    $params[$name]['type'] = $type;
                }
                if ($comment) {
                    $params[$name]['comment'] = $comment;
                }
            }
        }

        return $params;
    }

    /**
     * Gets the formal signature/declaration argument list ReST output
     *
     * @return string
     */
    protected function getArguments()
    {
        $strings = array();

        foreach ($this->getParameterInfo() as $name => $parameter) {
            $string = '';

            if ($parameter['hint_type']) {
                $string .= $parameter['hint_type'] . ' ';
            }

            $string .= '$' . $name;

            if (isset($parameter['default'])) {
                if ($parameter['default'] == '~~NOT RESOLVED~~') {
                    $parameter['default'] = '';
                }
                $string .= ' = ' . $parameter['default'];
            }

            $strings[] = $string;
        }

        return implode(', ', $strings);
    }

    /**
     * Gets an array of parameter information, in ReST format
     *
     * @return array
     */
    protected function getParameters()
    {
        $strings = array();

        foreach ($this->getParameterInfo() as $name => $parameter) {
            if ($parameter['type']) {
                $strings[] = ':type $' . $name . ': ' . $parameter['type'];
            }

            $string = ':param $' . $name . ':';

            if (isset($parameter['comment']) && $parameter['comment']) {
                $string .= ' ' . $parameter['comment'];
            }

             $strings[] = $string;
        }

        return $strings;
    }

    /**
     * Gets the return value ReST notation
     *
     * @return boolean|string
     */
    protected function getReturnValue()
    {
        $annotations = array_filter($this->getParser()->getAnnotations(), function ($v) {
            $e = explode(' ', $v);
            return isset($e[0]) && $e[0] == '@return';
        });
        foreach ($annotations as $parameter) {
            $parts = explode(' ', $parameter);

            if (count($parts) < 2) {
                continue;
            }

            $type = array_slice($parts, 1, 1);
            $type = $type[0];

            $comment = implode(' ', array_slice($parts, 2));

            return sprintf(
                ':returns: %s%s',
                $type ?: 'unknown',
                $comment ? ' ' . $comment : ''
            );
        }

        return false;
    }

    private function processMethodName($name)
    {
        if(strpos($name, '_POST'))
        {
            $httpMethod = 'POST';
        }
        else
        {
            $httpMethod = 'GET';
        }

        $name = str_replace(['_POST', '_GET'], ['', ''], $name);


        foreach($this->doctrineAnnotations as $a)
        {
            if($a instanceof HttpMethod)
            {
                $httpMethod = $a->value;
                break;
            }
        }

        return [$name, $httpMethod];
    }

    /**
     * @see \Phpdoc2rst\Element\Element::__toString()
     */
    public function __toString()
    {
        $methodName = $this->reflection->getName();

        list($methodName, $httpMethod) = $this->processMethodName($methodName);

        $string = sprintf(".. _%s:\n%s\n----\n", $methodName, $methodName);

        $string .= "Method: $httpMethod \n\n";

        $parser = $this->getParser();

        if ($description = $parser->getDescription())
        {
            $string .= $description . "\n\n";
        }

        return trim($string);
    }

    public function getDescription()
    {
        $parser = $this->getParser();

        return $parser->getDescription();
    }

    public function getHttpMethod()
    {
        return $this->httpMethod;
    }

    public function getName()
    {
        return $this->name;
    }

    public function isExcluded()
    {
        $result = false;

        foreach($this->doctrineAnnotations as $a)
        {
            if($a instanceof Exclude)
            {
                $result = true;
                break;
            }
        }

        return $result;
    }

    protected function getParser()
    {
        return new CommentParser($this->reflection->getDocComment());
    }
}