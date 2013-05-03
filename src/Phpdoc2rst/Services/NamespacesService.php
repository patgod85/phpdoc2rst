<?php
/**
 * Created by JetBrains PhpStorm.
 * User: victor
 * Date: 12.03.13
 * Time: 14:38
 * To change this template use File | Settings | File Templates.
 */

namespace Phpdoc2rst\Services;

use TokenReflection\Broker;

class NamespacesService
{
    public function getNamespaces($requestedNamespace, $inputFolder, $exclude)
    {
        $broker = new Broker($backend = new Broker\Backend\Memory());
        $broker->processDirectory($inputFolder);

        $namespaces = $backend->getNamespaces();
        ksort($namespaces);

        $excludedNamespaces = $this->getExcludedNamespaces($exclude);

        $filteredNamespaces = $this->getFilteredNamespaces($requestedNamespace, $namespaces, $excludedNamespaces);

        return $filteredNamespaces;
    }

    private function getFilteredNamespaces($requestedNamespace, $namespaces, $excludedNamespaces)
    {
        $filtered = array();

        foreach($namespaces as $n => $reflection)
        {
            if (substr($n, 0, strlen($requestedNamespace)) != $requestedNamespace)
            {
                continue;
            }

            foreach($excludedNamespaces as $exclude)
            {
                if (strncmp($n, $exclude, strlen($exclude)) == 0)
                {
                    continue 2;
                }
            }

            $filtered[$n] = $reflection;
        }

        return $filtered;
    }

    private function getExcludedNamespaces($exclude)
    {
        $excludes = [];

        if($exclude = trim($exclude))
        {
            $excludes = explode(';', $exclude);
        }

        return $excludes;
    }
}