<?php

namespace Patgod85\Phpdoc2rst\Command\Process\Controllers;

use Patgod85\Phpdoc2rst\Command\Process\Element\NamespaceElement;
use Patgod85\Phpdoc2rst\Command\Process\Services\NamespacesService;
use Patgod85\Phpdoc2rst\Command\Process\TemplateManager;
use Patgod85\Phpdoc2rst\Service\TrainSystemConnector;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class DefaultController
{
    /** @var OutputInterface */
    private $output;

    /** @var string */
    private $namespace;

    /** @var string */
    private $inputFolder;

    /** @var string */
    private $outputFolder;

    /** @var string */
    private $exclude;

    /** @var string */
    private $processingElements;

    /** @var TemplateManager */
    protected $templateManager;

    /** @var  TrainSystemConnector */
    protected $trainSystemConnector;

    function __construct(InputInterface $input, OutputInterface $output, TrainSystemConnector $trainSystemConnector)
    {
        $this->output = $output;

        $this->namespace = $input->getArgument('namespace');
        $this->inputFolder = $input->getArgument('path');
        $this->outputFolder  = realpath($input->getOption('output'));
        $this->exclude = $input->getOption('exclude');
        $this->processingElements = $input->getOption('target');

        $this->templateManager = new TemplateManager();

        $this->trainSystemConnector = $trainSystemConnector;

        $this->action();
    }

    private function action()
    {
        $this->logInput();

        $namespaces = $this->getNamespaces();

        foreach($namespaces as $n => $reflection)
        {
            $this->output->writeln(sprintf('<info>Processing %s</info>', $n));

            $namespace = new NamespaceElement($reflection);

            $this->processNamespace($namespace, $this->processingElements);
        }
    }

    protected function processNamespace(NamespaceElement $namespace, $processingElements)
    {
        switch($processingElements)
        {
            case 'methods':
                $this->processMethodsOfControllers($namespace);
                break;
            case 'exceptions':
                $this->processDescriptionsOfExceptions($namespace);
                break;
            case 'properties':
                $this->processPropertiesOfModels($namespace);
                break;
        }
    }

    abstract protected function processPropertiesOfModels(NamespaceElement $namespace);

    abstract protected function processMethodsOfControllers(NamespaceElement $namespace);

    abstract protected function processDescriptionsOfExceptions(NamespaceElement $namespace);

    private function logInput()
    {
        $this->output->writeln(sprintf('<comment>Processing code from namespace %s</comment>', $this->namespace));
        $this->output->writeln(sprintf('<comment>Processing files from %s</comment>', $this->inputFolder));
        $this->output->writeln(sprintf('<comment>Outputting to %s</comment>', $this->outputFolder));
    }

    private function getNamespaces()
    {
        $namespacesService = new NamespacesService();

        return $namespacesService->getNamespaces($this->namespace, $this->inputFolder, $this->exclude);
    }

    protected function putToFile($fileName, $content)
    {
        file_put_contents($this->outputFolder.DIRECTORY_SEPARATOR.$fileName, html_entity_decode($content, ENT_QUOTES));
    }
}