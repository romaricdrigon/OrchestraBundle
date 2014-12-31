<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Core\Pool;

use RomaricDrigon\OrchestraBundle\Core\Repository\RepositoryDefinitionInterface;

/**
 * Interface RepositoryPoolInterface
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
interface RepositoryPoolInterface
{
    /**
     * Add a repository definition to the pool
     *
     * @param RepositoryDefinitionInterface $repositoryDefinition
     */
    public function addRepositoryDefinition(RepositoryDefinitionInterface $repositoryDefinition);

    /**
     * @param string $slug
     * @return RepositoryDefinitionInterface
     */
    public function getBySlug($slug);

    /**
     * @return array all repository definitions indexed by slug
     */
    public function all();
}
