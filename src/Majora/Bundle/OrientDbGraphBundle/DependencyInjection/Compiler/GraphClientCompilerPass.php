<?php

namespace Majora\Bundle\OrientDbGraphBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\ExpressionLanguage\Expression;

/**
 * Compiler pass for "majora.graph_aware" tag handling
 */
class GraphClientCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('majora.orient_db.graph_engine')) {
            return;
        }

        $graphTags = $container->findTaggedServiceIds('majora.graph_client');
        $graphEngineDefinition = $container->getDefinition('majora.orient_db.graph_engine');

        foreach ($graphTags as $id => $tags) {
            foreach ($tags as $tag) {
                if (!isset($tag['vertex'])) {
                    throw new \InvalidArgumentException(sprintf(
                        'Missing "vertex" mandatory key into "%s" service "majora.graph_client" tag definition.',
                        $id
                    ));
                }

                $serviceDefinition = $container->getDefinition($id);
                $serviceDefinition->addMethodCall(
                    'setGraphDatabase',
                    array(
                        $tag['vertex'],
                        new Reference('majora.orient_db.graph_engine'),
                        $connection = isset($tag['connection']) ? $tag['connection'] : 'default'
                    )
                );

                $graphEngineDefinition->addMethodCall(
                    'registerVertex',
                    array($connection, $tag['vertex'])
                );
            }
        }
    }
}
