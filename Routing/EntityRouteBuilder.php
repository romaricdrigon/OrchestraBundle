<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Routing;

use RomaricDrigon\OrchestraBundle\Exception\EntityTwiceSameSlugException;
use Symfony\Component\Routing\Route;
use RomaricDrigon\OrchestraBundle\Core\Entity\EntityReflectionInterface;

/**
 * Class EntityRouteBuilder
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class EntityRouteBuilder implements EntityRouteBuilderInterface
{
    /**
     * @var string the controller action a repository will redirect to
     */
    protected $controller = 'RomaricDrigonOrchestraBundle:Generic:entityMethod';

    /**
     * @var string prefix to route name
     */
    protected $namePrefix = 'orchestra_entity';

    /**
     * @var string methods allowed to access to our entity
     */
    protected $methodRequirement = 'GET';

    /**
     * Route type declared
     */
    const ROUTE_TYPE = 'entity';

    /**
     * Builds all routes for given EntityReflection
     *
     * @param EntityReflectionInterface $entity
     * @param string $slug
     * @throws EntityTwiceSameSlugException
     * @return Route[] Routes, keys are route names
     */
    public function buildRoutes(EntityReflectionInterface $entity, $slug)
    {
        $methods = $entity->getMethods();

        $routes = [];

        foreach ($methods as $methodSlug => $method) {
            $methodName = $method->getShortName();

            // That should not happen, list being a PHP keyword
            // put there for later
            //if ('list' === $methodSlug) {
            //    throw new EntityTwiceSameSlugException($entity->getName(), $slug);
            //}

            $pattern = '/'.$slug.'/'.$methodSlug;
            $defaults = [
                '_controller'   => $this->controller,
                'entity_method' => $methodName,
                'method_slug'   => $methodSlug,
                'entity_slug'   => $slug,
                'type'          => $this::ROUTE_TYPE
            ];
            $requirements = [
                '_method'       => $this->methodRequirement
            ];

            $routeName = $this->namePrefix.'_'.$slug.'_'.$methodSlug;

            $routes[$routeName] = new Route($pattern, $defaults, $requirements);
        }

        return $routes;
    }
} 