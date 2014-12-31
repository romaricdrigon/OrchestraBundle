<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Core\Pool;

use RomaricDrigon\OrchestraBundle\Core\Repository\RepositoryDefinitionInterface;
use RomaricDrigon\OrchestraBundle\Exception\DomainErrorException;

/**
 * Class RepositoryPool
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 *
 * Represents a collection of all Repositories usable by Orchestra
 */
class RepositoryPool implements RepositoryPoolInterface
{
    /**
     * @var RepositoryDefinitionInterface[]
     */
    protected $repositoriesBySlug = [];

    /**
     * Add a repository definition to the pool
     *
     * @param RepositoryDefinitionInterface $repositoryDefinition
     * @throws DomainErrorException
     */
    public function addRepositoryDefinition(RepositoryDefinitionInterface $repositoryDefinition)
    {
        $slug = $repositoryDefinition->getSlug();

        if (isset($this->repositoriesBySlug[$slug])) {
            throw new DomainErrorException('Two repositories has the same "'.$slug.'" slug!');
        }

        $this->repositoriesBySlug[$slug] = $repositoryDefinition;
    }

    /**
     * @param string $slug
     * @return RepositoryDefinitionInterface
     * @throws DomainErrorException
     */
    public function getBySlug($slug)
    {
        if (! isset($this->repositoriesBySlug[$slug])) {
            throw new DomainErrorException('Unable to find repository for slug '.$slug.'. Maybe you forget to register it as a service with the the "orchestra.repository" tag?');
        }

        return $this->repositoriesBySlug[$slug];
    }

    /**
     * @return array all repositories indexed by slug
     */
    public function all()
    {
        return $this->repositoriesBySlug;
    }
}
