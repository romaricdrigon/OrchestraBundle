<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Routing;

use RomaricDrigon\OrchestraBundle\Core\Pool\RepositoryPoolInterface;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class RepositoryRouteCollectionBuilder
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class RepositoryRouteCollectionBuilder implements RepositoryRouteCollectionBuilderInterface
{
    /**
     * @var RepositoryRouteBuilderInterface
     */
    protected $repositoryRouteBuilder;

    public function __construct(RepositoryRouteBuilderInterface $repositoryRouteBuilder)
    {
        $this->repositoryRouteBuilder = $repositoryRouteBuilder;
    }

    /**
     * @inheritdoc
     */
    public function getCollection(RepositoryPoolInterface $pool)
    {
        $collection = new RouteCollection();
        $repositories = $pool->all();

        foreach ($repositories as $slug => $repository) {
            $routeName = $this->repositoryRouteBuilder->buildRouteName($slug);
            $route = $this->repositoryRouteBuilder->buildRoute($repository, $slug);

            $collection->add($routeName, $route);
        }

        return $collection;
    }
} 