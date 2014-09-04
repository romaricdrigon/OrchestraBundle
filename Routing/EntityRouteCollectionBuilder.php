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
 * Class EntityRouteCollectionBuilder
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class EntityRouteCollectionBuilder implements EntityRouteCollectionBuilderInterface
{
    /**
     * @var EntityRouteBuilderInterface
     */
    protected $entityRouteBuilder;

    public function __construct(EntityRouteBuilderInterface $entityRouteBuilder)
    {
        $this->entityRouteBuilder = $entityRouteBuilder;
    }

    /**
     * @inheritdoc
     */
    public function getCollection(EntityPoolInterface $pool)
    {
        $collection = new RouteCollection();
        $entities   = $pool->all();

        foreach ($entities as $entity) {
            $routes = $this->entityRouteBuilder->buildRoutes($entity);

            foreach ($routes as $routeName => $route) {
                $collection->add($routeName, $route);
            }
        }

        return $collection;
    }
} 