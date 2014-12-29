<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Resolver;

use RomaricDrigon\OrchestraBundle\Core\Repository\RepositoryDefinitionInterface;

/**
 * Interface RepositoryNameResolverInterface
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
interface RepositoryNameResolverInterface
{
    /**
     * Get the repository name, to display
     * There may be none, and we will generate a default then
     *
     * @param RepositoryDefinitionInterface $repositoryDefinition
     * @return string
     */
    public function getName(RepositoryDefinitionInterface $repositoryDefinition);
}
