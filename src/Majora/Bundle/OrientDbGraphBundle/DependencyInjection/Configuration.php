<?php

namespace Majora\Bundle\OrientDbGraphBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $treeBuilder->root('majora_orient_db_graph')
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('host')
                    ->isRequired()->cannotBeEmpty()
                ->end()
                ->scalarNode('port')
                    ->isRequired()
                ->end()
                ->scalarNode('timeout')
                    ->isRequired()
                ->end()
                ->scalarNode('user')
                    ->isRequired()->cannotBeEmpty()
                ->end()
                ->scalarNode('password')
                    ->isRequired()
                ->end()
                ->scalarNode('database')
                    ->isRequired()->cannotBeEmpty()
                ->end()
                ->scalarNode('data_type')
                    ->defaultValue('graph')
                    ->validate()
                    ->ifNotInArray(array('graph', 'document'))
                        ->thenInvalid('Invalid OrientDB data-type "%s"')
                    ->end()
                ->end()
                ->scalarNode('storage_type')
                    ->defaultValue('plocal')
                    ->validate()
                    ->ifNotInArray(array('memory', 'plocal'))
                        ->thenInvalid('Invalid OrientDB storage-type "%s"')
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
