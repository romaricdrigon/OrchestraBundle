<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Core\Repository\Action;

use RomaricDrigon\OrchestraBundle\Core\Repository\RepositoryDefinitionInterface;

/**
 * Interface RepositoryActionBuilderInterface
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
interface RepositoryActionBuilderInterface
{
    /**
     * @param RepositoryDefinitionInterface $repositoryDefinition
     * @param \ReflectionMethod $reflectionMethod
     * @return RepositoryActionInterface|null
     */
    public function build(RepositoryDefinitionInterface $repositoryDefinition, \ReflectionMethod $reflectionMethod);
}
