<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\DependencyInjection\Compiler;

use RomaricDrigon\OrchestraBundle\Exception\ConfigurationException;
use RomaricDrigon\OrchestraBundle\Exception\OrchestraRuntimeException;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class AddRepositoryCompilerPass
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class AddRepositoryCompilerPass implements CompilerPassInterface
{
    const REPOSITORY_POOL_FACTORY_SERVICE_ID = 'orchestra.pool.repository_pool_factory';

    const OBJECT_MANAGER_SERVICE_ID = 'orchestra.doctrine.object_manager';

    const DOCTRINE_ENTITY_MANAGER_SERVICE_ID = 'doctrine.orm.entity_manager';

    const DOCTRINE_REPOSITORY_PREFIX = 'orchestra.doctrine_repository.';

    /**
     * @inheritdoc
     */
    public function process(ContainerBuilder $container)
    {
        if (! $container->hasDefinition(self::REPOSITORY_POOL_FACTORY_SERVICE_ID)) {
            throw new OrchestraRuntimeException('Orchestra RepositoryPoolFactory is unavailable');
        }

        $repositoryPoolFactory = $container->getDefinition(self::REPOSITORY_POOL_FACTORY_SERVICE_ID);

        $taggedServices = $container->findTaggedServiceIds('orchestra.repository');

        foreach ($taggedServices as $id => $tags) {
            if (count($tags) > 1) {
                throw new ConfigurationException('Service "'.$id.'" have more than one "orchestra_repository" tag, which is not allowed');
            }

            $tagAttributes = $tags[0];

            if (!isset($tagAttributes['entityClass'])) {
                throw new ConfigurationException('Orchestra Repository "' . $id . '" is declared without the required "entityClass" attribute in service declaration!');
            }

            $definition = $container->getDefinition($id);
            $class = $definition->getClass();
            $reflection = new \ReflectionClass($class);
            $entityClass = $tagAttributes['entityClass'];

            // Add it to the Pool
            $repositoryPoolFactory->addMethodCall('addRepository', [$class, $id, $entityClass]);

            // It's also now we see if we need to inject it a Doctrine Repository
            if ($reflection->implementsInterface('RomaricDrigon\OrchestraBundle\Domain\Doctrine\DoctrineAwareInterface')) {
                $definition->addMethodCall('setObjectManager', [new Reference(self::OBJECT_MANAGER_SERVICE_ID)]);

                // Because Doctrine repositories are complex, we need to add them as services first
                $doctrineServiceName = self::DOCTRINE_REPOSITORY_PREFIX . $entityClass;

                if (!$container->has($doctrineServiceName)) {
                    $doctrineRepositoryDefinition = (new Definition('Doctrine\ORM\EntityRepository')) // we are forced to give a class
                        ->setFactoryService(self::DOCTRINE_ENTITY_MANAGER_SERVICE_ID)
                        ->setFactoryMethod('getRepository')
                        ->addArgument($entityClass);
                    $container->addDefinitions([
                        $doctrineServiceName => $doctrineRepositoryDefinition
                    ]);
                }

                $definition->addMethodCall('setDoctrineRepository', [new Reference($doctrineServiceName)]);
            }
        }
    }
}
