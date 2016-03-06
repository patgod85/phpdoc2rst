<?php

namespace Patgod85\Phpdoc2rst\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class Patgod85Phpdoc2rstExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $container->setParameter('patgod85_phpdoc2rst', $config);
        $container->setParameter('patgod85_phpdoc2rst.errors_provider', $config['errors_provider']);
    }
    public function getAlias()
    {
        return 'patgod85_phpdoc2rst';
    }
}