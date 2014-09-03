<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Routing;

use RomaricDrigon\OrchestraBundle\Core\Repository\Action\RepositoryActionCollectionBuilderInterface;
use Symfony\Component\Routing\Route;
use RomaricDrigon\OrchestraBundle\Domain\Repository\RepositoryInterface;
use RomaricDrigon\OrchestraBundle\Core\Repository\Action\RepositoryActionInterface;

/**
 * Class RepositoryRouteBuilder
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class RepositoryRouteBuilder implements RepositoryRouteBuilderInterface
{
    /**
     * @var string the controller "listing" action will redirect to
     */
    protected $listingController = 'RomaricDrigonOrchestraBundle:Generic:list';

    /**
     * @var string the controller action a repository method will redirect to
     */
    protected $genericController = 'RomaricDrigonOrchestraBundle:Generic:repositoryMethod';

    /**
     * @var string methods allowed to o access to our repository
     */
    protected $methodRequirement = 'GET';

    /**
     * @var RepositoryActionCollectionBuilderInterface
     */
    protected $repositoryActionCollectionBuilder;

    /**
     * Route type declared
     */
    const ROUTE_TYPE = 'repository';


    /**
     * @param RepositoryActionCollectionBuilderInterface $repositoryActionCollectionBuilder
     */
    public function __construct(RepositoryActionCollectionBuilderInterface $repositoryActionCollectionBuilder)
    {
        $this->repositoryActionCollectionBuilder = $repositoryActionCollectionBuilder;
    }

    /**
     * @inheritdoc
     */
    public function buildRoutes(RepositoryInterface $repositoryInterface, $slug)
    {
        $collection = $this->repositoryActionCollectionBuilder->build($repositoryInterface);

        $routes = [];

        /** @var RepositoryActionInterface $action */
        foreach ($collection as $action) {
            $controller = $this->genericController;

            if (true === $action->isListing()) {
                $controller = $this->listingController;
            }

            $pattern = '/'.$slug.'/'.$action->getSlug();
            $defaults = [
                '_controller'       => $controller,
                'orchestra_type'    => $this::ROUTE_TYPE,
                'repository_method' => $action->getMethod(),
                'repository_slug'   => $slug
            ];
            $requirements = [
                '_method'       => $this->methodRequirement
            ];

            $route = new Route($pattern, $defaults, $requirements);
            $routeName = $action->getRouteName();

            $routes[$routeName] = $route;
        }

        return $routes;
    }
} 