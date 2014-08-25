<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Routing;

use Symfony\Component\Routing\Route;
use RomaricDrigon\OrchestraBundle\Pool\EntityReflectionInterface;

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
     * @inheritdoc
     */
    public function buildRoutes(EntityReflectionInterface $entity, $slug)
    {
        // TODO: list methods on entity

        $temp = 'void';

        $pattern = '/'.$slug.'/'.$temp;
        $defaults = [
            '_controller'   => $this->controller,
            'entity_method' => $temp,
            'entity_slug'   => $slug
        ];
        $requirements = [
            '_method'       => $this->methodRequirement
        ];

        $routeName = $this->namePrefix.'_'.$slug.'_'.$temp;

        return [
            $routeName => new Route($pattern, $defaults, $requirements)
        ];
    }
} 