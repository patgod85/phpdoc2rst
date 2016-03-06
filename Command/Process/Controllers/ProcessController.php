<?php

namespace Patgod85\Phpdoc2rst\Command\Process\Controllers;


use Patgod85\Phpdoc2rst\Command\Process\Element\NamespaceElement;
use Patgod85\Phpdoc2rst\Command\Process\Services\TrainSystemConnector;

class ProcessController extends DefaultController
{
    protected function processDescriptionsOfExceptions(NamespaceElement $namespace)
    {
        $trainsSystemConnector = new TrainSystemConnector();

        $exceptions = array_merge(
            $namespace->getExceptions(),
            $trainsSystemConnector->getAdditionalExceptions()
        );

        $template = $this->templateManager->render(
            'exceptions.twig',
            ['exceptions' => $exceptions]
        );

        $this->putToFile('errors.rst', $template);
    }

    protected function processMethodsOfControllers(NamespaceElement $namespace)
    {
        $this->processClassMembers($namespace, 'methodsOfController.twig');
    }

    protected function processPropertiesOfModels(NamespaceElement $namespace)
    {
        $this->processClassMembers($namespace, 'propertiesOfModel.twig');
    }

    private function processClassMembers(NamespaceElement $namespace, $templateFileName)
    {
        foreach ($namespace->getClasses() as $class)
        {
            $template = $this->templateManager->render(
                $templateFileName,
                ['class' => $class]
            );

            $this->putToFile($class->getName().'.rst', $template);
        }
    }
}