<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Resolver\RepositoryRouteName;

use RomaricDrigon\OrchestraBundle\Core\Repository\RepositoryDefinitionInterface;

/**
 * Class RepositoryRouteNameResolver
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class RepositoryRouteNameResolver implements RepositoryRouteNameResolverInterface
{
    /**
     * @inheritdoc
     */
    public function getRouteName(RepositoryDefinitionInterface $repositoryDefinition, $methodName)
    {
        $slug = $repositoryDefinition->getSlug();

        return $this::NAME_PREFIX.'_'.$slug.'_'.strtolower($methodName);
    }
}
