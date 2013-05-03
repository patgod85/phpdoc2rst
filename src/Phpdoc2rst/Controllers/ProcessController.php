<?php
/**
 * Created by JetBrains PhpStorm.
 * User: victor
 * Date: 12.03.13
 * Time: 13:33
 * To change this template use File | Settings | File Templates.
 */

namespace Phpdoc2rst\Controllers;


use Phpdoc2rst\Element\NamespaceElement;
use Phpdoc2rst\Modules\TrainSystemConnector;

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