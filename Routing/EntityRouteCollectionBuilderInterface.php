<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Routing;

use RomaricDrigon\OrchestraBundle\Core\Pool\EntityPoolInterface;
use Symfony\Component\Routing\RouteCollection;

/**
 * Interface EntityRouteCollectionBuilderInterface
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
interface EntityRouteCollectionBuilderInterface
{
    /**
     * @param EntityPoolInterface $pool
     * @return RouteCollection
     */
    public function getCollection(EntityPoolInterface $pool);
} 