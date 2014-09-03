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
     * @var string the controller action a repository method accepting a Command will redirect to
     */
    protected $commandController = 'RomaricDrigonOrchestraBundle:Generic:repositoryCommand';

    /**
     * @var string methods allowed to access to our repository
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
            $pattern = '/'.$slug.'/'.$action->getSlug();
            $defaults = [
                '_controller'       => $this->genericController,
                'orchestra_type'    => $this::ROUTE_TYPE,
                'repository_method' => $action->getMethod(),
                'repository_slug'   => $slug
            ];
            $requirements = [
                '_method'       => $this->methodRequirement
            ];

            if (true === $action->isListing()) {
                $defaults['_controller'] = $this->listingController;
            }

            if (true === $action->isCommand()) {
                $defaults['_controller'] = $this->commandController;

                // We add a "command"
                $defaults['command_class'] = $action->getCommandClass();

                $requirements['_method'] = 'GET|POST';
            }

            $route = new Route($pattern, $defaults, $requirements);
            $routeName = $action->getRouteName();

            $routes[$routeName] = $route;
        }

        return $routes;
    }
} 