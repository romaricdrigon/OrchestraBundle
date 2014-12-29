<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Core\Pool;

use RomaricDrigon\OrchestraBundle\Domain\Repository\RepositoryInterface;
use RomaricDrigon\OrchestraBundle\Exception\DomainErrorException;
use RomaricDrigon\OrchestraBundle\Exception\RepositoryAddedTwiceException;

/**
 * Class RepositoryPool
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 *
 * Represents a collection of all Repositories usable by Orchestra
 */
class RepositoryPool implements RepositoryPoolInterface
{
    protected $repositoriesBySlug = [];

    /**
     * Add a repository to the pool
     *
     * @param RepositoryInterface $repository
     * @throws RepositoryAddedTwiceException
     */
    public function addRepository(RepositoryInterface $repository)
    {
        // At the moment slug is not configurable otherwise
        $reflect = new \ReflectionClass($repository);
        $slug = strtolower(str_replace('Repository', '', $reflect->getShortName()));

        if (isset($this->repositoriesBySlug[$slug])) {
            throw new RepositoryAddedTwiceException($slug);
        }

        $this->repositoriesBySlug[$slug] = $repository;
    }

    /**
     * @param string $slug
     * @return RepositoryInterface
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