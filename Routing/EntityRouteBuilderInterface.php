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
 * Interface EntityRouteBuilderInterface
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
interface EntityRouteBuilderInterface
{
    /**
     * Builds all routes for given EntityReflection
     *
     * @param EntityReflectionInterface $entity
     * @param string $slug
     * @return Route[] Routes, keys are route names
     */
    public function buildRoutes(EntityReflectionInterface $entity, $slug);
} 