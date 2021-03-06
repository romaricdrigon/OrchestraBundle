<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\DependencyInjection\Compiler;

use RomaricDrigon\OrchestraBundle\Exception\OrchestraRuntimeException;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class AddEntityCompilerPass
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class AddEntityCompilerPass implements CompilerPassInterface
{
    /**
     * @inheritdoc
     */
    public function process(ContainerBuilder $container)
    {
        if (! $container->hasDefinition('orchestra.finder.entity_finder')) {
            throw new OrchestraRuntimeException('Orchestra EntityFinder is unavailable');
        }

        $bundles = $container->getParameter('kernel.bundles');

        $entityFinder = $container->getDefinition('orchestra.finder.entity_loader');

        // For each bundle, we run our EntityFinder
        foreach ($bundles as $bundleNamespace) {
            $entityFinder->addMethodCall('addBundleNamespace', [$bundleNamespace]);
        }
    }
}
