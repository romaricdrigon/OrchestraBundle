<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace RomaricDrigon\OrchestraBundle\Core\Repository;

use RomaricDrigon\OrchestraBundle\Resolver\Repository\RepositoryNameResolver;

/**
 * Class RepositoryDefinitionFactory
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class RepositoryDefinitionFactory
{
    /**
     * @var RepositoryNameResolver
     */
    protected $nameResolver;

    /**
     * @param RepositoryNameResolver $nameResolver
     */
    public function __construct(RepositoryNameResolver $nameResolver)
    {
        $this->nameResolver = $nameResolver;
    }

    /**
     * @param string $repositoryClass
     * @param string $serviceId
     * @param string $entityClass
     * @return RepositoryDefinition
     */
    public function build($repositoryClass, $serviceId, $entityClass)
    {
        $reflectionClass = new \ReflectionClass($repositoryClass);

        $name = $this->nameResolver->getName($repositoryClass);

        return new RepositoryDefinition($reflectionClass, $serviceId, $entityClass, $name);
    }
}
