<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Core\Pool;

use RomaricDrigon\OrchestraBundle\Domain\Repository\RepositoryInterface;

/**
 * Interface RepositoryPoolInterface
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
interface RepositoryPoolInterface
{
    /**
     * Add a repository to the pool
     *
     * @param RepositoryInterface $repository
     */
    public function addRepository(RepositoryInterface $repository);

    /**
     * @param string $slug
     * @return RepositoryInterface
     */
    public function getBySlug($slug);

    /**
     * @return array all repositories indexed by slug
     */
    public function all();
} 