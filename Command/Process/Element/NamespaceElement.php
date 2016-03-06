<?php

namespace Patgod85\Phpdoc2rst\Command\Process\Element;

use TokenReflection\ReflectionNamespace;
use Symfony\Component\Console\Output\OutputInterface;

class NamespaceElement extends Element
{
    /**
     * @var ReflectionNamespace
     */
    protected $reflection;

    protected $titles = array('`', ':', '\'', '"', '~', '^', '_', '*', '+', '#', '<', '>');

    public function __construct(ReflectionNamespace $namespace)
    {
        parent::__construct($namespace);
    }

    public function getPath()
    {
        return str_replace('\\', DIRECTORY_SEPARATOR, $this->reflection->getName());
    }

    protected function getSubElements()
    {
        $elements = array_merge(
            $this->getConstants()
        );

        return $elements;
    }

    protected function getConstants()
    {
        return array_map(function ($v) {
            return new ConstantElement($v);
        }, $this->reflection->getConstants());
    }


    /**
     * @return ClassElement[]
     */
    public function getClasses()
    {
        return array_map(function ($v) {
            return new ClassElement($v);
        }, $this->reflection->getClasses());
    }

    /**
     * @return ExceptionElement[]
     */
    public function getExceptions()
    {
        return array_map(function ($v) {
            return new ExceptionElement($v);
        }, $this->reflection->getClasses());
    }

    public function __toString()
    {
        $string = '';

        /** @var Element $element */
        foreach ($this->getSubElements() as $element)
        {
            $e = $element->__toString();
            if($e)
            {
                $string .= $this->indent($e, 4);
                $string .= "\n\n";
            }
        }

        return $string;
    }

    /**
     * Ensures the build directory is in place
     *
     * @param string $path
     * @param OutputInterface $output
     * @return string The directory
     */
    protected function ensureBuildDir($path, OutputInterface $output)
    {
        $parts = explode(DIRECTORY_SEPARATOR, $this->getPath());

        foreach ($parts as $part) {
            if (!$part) continue;

            $path .= DIRECTORY_SEPARATOR . $part;

            if (!file_exists($path)) {
                $output->writeln(sprintf('<info>Creating namespace build directory: <comment>%s</comment></info>', $path));
                mkdir($path);
            }
        }

        return $path;
    }

    /**
     * Builds the class information
     *
     * @param string $basedir
     * @param OutputInterface $output
     * @param string $elementsForOutput
     * @return void
     */
    public function buildClasses($basedir, OutputInterface $output, $elementsForOutput)
    {
        $target = $this->ensureBuildDir($basedir, $output);

//        if($elementsForOutput == 'exceptions')
//        {
//            $this->buildExceptionsMap($basedir);
//        }
//        else
//        {
            foreach ($this->getClasses() as $element)
            {
                $element->build($target, $elementsForOutput);
            }
//        }
    }

//    private function buildExceptionsMap($basedir)
//    {
//        $template = $this->templateManager->render(
//            'exceptions.html.twig',
//            ['exceptions' => $this->getExceptions()]
//        );
//
//        $file = $basedir . DIRECTORY_SEPARATOR . 'errors.rst';
//        file_put_contents($file, $template);
//    }
}