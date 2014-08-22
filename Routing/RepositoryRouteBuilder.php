<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Routing;

use RomaricDrigon\OrchestraBundle\Pool\RepositoryPool;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class RepositoryRouteBuilder
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class RepositoryRouteBuilder
{
    /**
     * @var RepositoryPool
     */
    protected $pool;

    protected $controller = 'RomaricDrigonOrchestraBundle:Generic:list';

    protected $repositoryMethod = 'all';

    protected $patternSuffix = 'list';

    protected $namePrefix = 'orchestra_repository';

    protected $nameSuffix = 'list';

    protected $methodRequirement = 'GET';

    public function __construct(RepositoryPool $pool)
    {
        $this->pool = $pool;
    }

    /**
     * Build a RouteCollection from all Orchestra-enabled repositories
     *
     * @return RouteCollection
     */
    public function getCollection()
    {
        $routes = new RouteCollection();
        $repositories = $this->pool->all();

        foreach ($repositories as $slug => $repository) {
            $pattern = '/'.$slug.'/'.$this->patternSuffix;
            $defaults = [
                '_controller'   => $this->controller,
                'repository_method' => $this->repositoryMethod,
                'repository_slug'   => $slug
            ];
            $requirements = [
                '_method'       => $this->methodRequirement
            ];

            $route = new Route($pattern, $defaults, $requirements);

            $name = $this->namePrefix.'_'.$slug.'_'.$this->nameSuffix;

            $routes->add($name, $route);
        }

        return $routes;
    }
} 