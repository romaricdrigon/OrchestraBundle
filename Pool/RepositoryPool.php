<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Pool;

use RomaricDrigon\OrchestraBundle\Domain\RepositoryInterface;
use RomaricDrigon\OrchestraBundle\Exception\RepositoryAddedTwiceException;
use RomaricDrigon\OrchestraBundle\Exception\RepositoryNotFoundException;

/**
 * Class RepositoryPool
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 *
 * Represents a collection of all Repositories usable by Orchestra
 */
class RepositoryPool
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
        $slug = strtolower(str_replace('Repository', '', get_class($repository)));

        if (isset($this->repositoriesBySlug[$slug])) {
            throw new RepositoryAddedTwiceException($slug);
        }

        $this->repositoriesBySlug[$slug] = $repository;
    }

    /**
     * @param string $slug
     * @return RepositoryInterface
     * @throws RepositoryNotFoundException
     */
    public function getBySlug($slug)
    {
        if (! isset($this->repositoriesBySlug[$slug])) {
            throw new RepositoryNotFoundException($slug);
        }

        return $this->repositoriesBySlug[$slug];
    }
}