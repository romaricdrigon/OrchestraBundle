<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Core\Repository;

/**
 * Class RepositoryDefinitionFactory
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class RepositoryDefinitionFactory
{
    /**
     * @param string $repositoryClass
     * @param string $serviceId
     * @param string $entityClass
     * @return RepositoryDefinition
     */
    public function build($repositoryClass, $serviceId, $entityClass)
    {
        $reflectionClass = new \ReflectionClass($repositoryClass);

        return new RepositoryDefinition($reflectionClass, $serviceId, $entityClass);
    }
}
