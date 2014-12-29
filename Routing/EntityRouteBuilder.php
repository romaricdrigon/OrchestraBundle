<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Routing;

use RomaricDrigon\OrchestraBundle\Core\Entity\Action\EntityActionInterface;
use RomaricDrigon\OrchestraBundle\Core\Entity\Action\EntityActionCollectionBuilderInterface;
use Symfony\Component\Routing\Route;
use RomaricDrigon\OrchestraBundle\Core\Entity\EntityReflectionInterface;

/**
 * Class EntityRouteBuilder
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class EntityRouteBuilder implements EntityRouteBuilderInterface
{
    /**
     * @var string the controller action an entity method will redirect to
     */
    protected $queryController = 'RomaricDrigonOrchestraBundle:Generic:entityQuery';

    /**
     * @var string the controller action an entity method accepting a Command will redirect to
     */
    protected $commandController = 'RomaricDrigonOrchestraBundle:Generic:entityCommand';

    /**
     * @var string the controller action an entity method with a "EmitEvent" annotation will redirect to
     */
    protected $eventController = 'RomaricDrigonOrchestraBundle:Generic:entityEvent';

    /**
     * @var string methods allowed to access to our entity
     */
    protected $methodRequirement = 'GET';

    /**
     * Route type declared
     */
    const ROUTE_TYPE = 'entity';

    /**
     * @var EntityActionCollectionBuilderInterface
     */
    protected $entityActionCollectionBuilder;


    public function __construct(EntityActionCollectionBuilderInterface $entityActionCollectionBuilder)
    {
        $this->entityActionCollectionBuilder = $entityActionCollectionBuilder;
    }

    /**
     * Builds all routes for given EntityReflection
     *
     * @param EntityReflectionInterface $entity
     * @return Route[] Routes, keys are route names
     */
    public function buildRoutes(EntityReflectionInterface $entity)
    {
        $collection = $this->entityActionCollectionBuilder->build($entity);

        $routes = [];

        /** @var EntityActionInterface $action */
        foreach ($collection as $action) {
            $pattern = '/'.$entity->getSlug().'/'.$action->getSlug();
            $defaults = [
                '_controller'   => $this->queryController,
                'orchestra_type' => $this::ROUTE_TYPE,
                'entity_method' => $action->getMethod(),
                'method_slug'   => $action->getSlug(),
                'entity_slug'   => $entity->getSlug()
            ];
            $requirements = [
                '_method'       => $this->methodRequirement
            ];

            if (true === $action->isCommand()) {
                $defaults['_controller'] = $this->commandController;

                // We add a "command"
                $defaults['command_class'] = $action->getCommandClass();

                $requirements['_method'] = 'GET|POST';
            }

            if (true === $action->emitEvent()) {
                $defaults['_controller'] = $this->eventController;
            }

            $route = new Route($pattern, $defaults, $requirements);
            $routeName = $action->getRouteName();

            $routes[$routeName] = $route;
        }

        return $routes;
    }
}
