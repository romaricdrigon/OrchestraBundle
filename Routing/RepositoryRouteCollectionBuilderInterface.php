<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Routing;

use Symfony\Component\Routing\RouteCollection;
use RomaricDrigon\OrchestraBundle\Core\Pool\RepositoryPoolInterface;

/**
 * Interface RepositoryRouteCollectionBuilderInterface
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
interface RepositoryRouteCollectionBuilderInterface
{
    /**
     * Build a RouteCollection from all Orchestra-enabled repositories
     *
     * @param RepositoryPoolInterface $pool
     * @return RouteCollection
     */
    public function getCollection(RepositoryPoolInterface $pool);
} 