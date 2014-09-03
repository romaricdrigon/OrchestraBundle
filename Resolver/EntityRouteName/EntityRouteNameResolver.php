<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Resolver\EntityRouteName;

use RomaricDrigon\OrchestraBundle\Core\Entity\EntityReflectionInterface;

/**
 * Class EntityRouteNameResolver
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class EntityRouteNameResolver implements EntityRouteNameResolverInterface
{
    /**
     * @inheritdoc
     */
    public function getRouteName(EntityReflectionInterface $entityReflection, $methodName)
    {
        return $this::NAME_PREFIX.'_'.$entityReflection->getSlug().'_'.strtolower($methodName);
    }
} 