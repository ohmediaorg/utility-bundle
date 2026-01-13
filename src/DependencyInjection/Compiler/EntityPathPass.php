<?php

namespace OHMedia\UtilityBundle\DependencyInjection\Compiler;

use OHMedia\UtilityBundle\Service\EntityPathManager;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class EntityPathPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        // always first check if the primary service is defined
        if (!$container->has(EntityPathManager::class)) {
            return;
        }

        $definition = $container->findDefinition(EntityPathManager::class);

        $tagged = $container->findTaggedServiceIds('oh_media_utility.entity_path_provider');

        foreach ($tagged as $id => $tags) {
            $definition->addMethodCall('addProvider', [new Reference($id)]);
        }
    }
}
