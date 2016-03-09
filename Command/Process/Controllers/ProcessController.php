<?php

namespace Patgod85\Phpdoc2rst\Command\Process\Controllers;

use Patgod85\Phpdoc2rst\Command\Process\Element\NamespaceElement;

class ProcessController extends DefaultController
{
    protected function processDescriptionsOfExceptions(NamespaceElement $namespace)
    {
        $exceptions = array_merge(
            $namespace->getExceptions(),
            $this->trainSystemConnector->getAdditionalExceptions()
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
            if(!$class->isExcluded())
            {
                $template = $this->templateManager->render(
                    $templateFileName,
                    ['class' => $class]
                );

                $this->putToFile($class->getName() . '.rst', $template);
            }
        }
    }
}