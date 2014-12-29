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
 * Class AddRepositoryCompilerPass
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class AddRepositoryCompilerPass implements CompilerPassInterface
{
    /**
     * @var string prefix we use to generated Doctrine Repositories services ID
     */
    protected $generatedRepositoryPrefix = 'orchestra.doctrine.repository';

    /**
     * @inheritdoc
     */
    public function process(ContainerBuilder $container)
    {
        if (! $container->hasDefinition('orchestra.pool.repository_pool')) {
            throw new OrchestraRuntimeException('Orchestra RepositoryPool is unavailable');
        }

        $repositoryPool = $container->getDefinition('orchestra.pool.repository_pool');

        $taggedServices = $container->findTaggedServiceIds('orchestra.repository');

        foreach ($taggedServices as $id => $tagAttributes) {
            $definition = $container->getDefinition($id);

            $repositoryPool->addMethodCall('addRepository', [$definition->getClass(), $id]);
        }
    }
}
