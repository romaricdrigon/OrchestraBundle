<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\DependencyInjection\Compiler;

use RomaricDrigon\OrchestraBundle\Exception\UnavailableRepositoryPoolException;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use RomaricDrigon\OrchestraBundle\Exception\DoctrineRepositoryGeneratedTwiceException;

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


    public function process(ContainerBuilder $container)
    {
        if (! $container->hasDefinition('orchestra.pool.repository_pool')) {
            throw new UnavailableRepositoryPoolException();
        }

        $repositoryPool = $container->getDefinition('orchestra.pool.repository_pool');

        $taggedServices = $container->findTaggedServiceIds('orchestra.repository');

        foreach ($taggedServices as $id => $tagAttributes) {
            if (true === $this->checkIfBaseRepository($tagAttributes)) {
                $this->buildBaseRepository($container, $id);
            }

            $repositoryPool->addMethodCall('addRepository', [new Reference($id)]);
        }
    }

    /**
     * Checks if among given tag attributes we have base=="true"
     *
     * @param $tagAttributes
     * @return bool
     */
    protected function checkIfBaseRepository($tagAttributes)
    {
        foreach ($tagAttributes as $attribute) {
            if (isset($attribute['base']) && true === $attribute['base']) {
                return true;
            }
        }

        return false;
    }

    /**
     * Correctly build given instance of BaseRepository
     *
     * @param ContainerBuilder $containerBuilder
     * @param $serviceId
     * @throws DoctrineRepositoryGeneratedTwiceException
     */
    protected function buildBaseRepository(ContainerBuilder $containerBuilder, $serviceId)
    {
        $doctrineEntityName = $this->getDoctrineEntityName();

        $id = $this->buildDoctrineRepositoryId($doctrineEntityName);

        if ($containerBuilder->hasDefinition($id)) {
            throw new DoctrineRepositoryGeneratedTwiceException('generating twice the same repository!');
        }

        $definition = $this->buildDoctrineRepositoryDefinition($doctrineEntityName);

        $containerBuilder->setDefinition($id, $definition);

        $orchestraRepositoryDefinition = $containerBuilder->getDefinition($serviceId);

        $orchestraRepositoryDefinition->addMethodCall('setDoctrineRepository', [new Reference($id)]);
    }

    protected function getDoctrineEntityName()
    {
        return 'foo';
    }

    /**
     * Build a service definition
     *
     * @param string $doctrineEntityName
     * @return Definition
     */
    protected function buildDoctrineRepositoryDefinition($doctrineEntityName)
    {
        $definition = (new Definition())
            ->setFactoryService('doctrine.orm.default_entity_manager')
            ->setFactoryMethod('getRepository')
            ->setArguments([$doctrineEntityName])
        ;

        return $definition;
    }

    /**
     * Returns an ID
     *
     * @param string $doctrineEntityName
     * @return string
     */
    protected function buildDoctrineRepositoryId($doctrineEntityName)
    {
        return $this->generatedRepositoryPrefix.'.'.$doctrineEntityName;
    }

    /**
     * Create a call to add Doctrine repository to "Orchestra" registered service
     *
     * @param ContainerBuilder $containerBuilder
     * @param string $serviceId
     * @param string $doctrineRepositoryId
     */
    protected function injectDoctrineRepositoryCall(ContainerBuilder $containerBuilder, $serviceId, $doctrineRepositoryId)
    {
        $repositoryService = $containerBuilder->get($serviceId);

        $repositoryService->addMethodCall('setDoctrineRepository', [new Reference($doctrineRepositoryId)]);
    }
} 