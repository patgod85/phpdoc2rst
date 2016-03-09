<?php

namespace Patgod85\Phpdoc2rst\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('patgod85_phpdoc2rst');

        $rootNode
            ->children()
                ->scalarNode('errors_provider')->end()
                ->arrayNode('tasks')
                    ->prototype('array')
                        ->children()
                            ->arrayNode('subtasks')
                                ->requiresAtLeastOneElement()
                                ->prototype('array')
                                    ->children()
                                        ->scalarNode('target')->end()
                                        ->scalarNode('namespace')
                                            ->isRequired()
                                        ->end()
                                        ->scalarNode('input')
                                            ->isRequired()
                                        ->end()
                                        ->scalarNode('output')
                                            ->isRequired()
                                        ->end()
                                        ->scalarNode('exclude')->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
        return $treeBuilder;
    }

}