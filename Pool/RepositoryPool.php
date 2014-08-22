<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Pool;

use RomaricDrigon\OrchestraBundle\Domain\RepositoryInterface;

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
     * @throws \Exception if we try to add twice a repository
     */
    public function addRepository(RepositoryInterface $repository)
    {
        // At the moment slug is not configurable otherwise
        $slug = strtolower(get_class($repository));

        if (isset($this->repositoriesBySlug[$slug])) {
            throw new \Exception('Repository with slug '.$slug.' seems to be registered twice!');
        }

        $this->repositoriesBySlug[$slug] = $repository;
    }

    /**
     * @param string $slug
     * @return RepositoryInterface
     * @throws \Exception
     */
    public function getBySlug($slug)
    {
        if (! isset($this->repositoriesBySlug[$slug])) {
            throw new \Exception('Unable to find repository for slug '.$slug.'. Maybe you forget to register it with the the orchestra.repository tag?');
        }

        return $this->repositoriesBySlug[$slug];
    }
}