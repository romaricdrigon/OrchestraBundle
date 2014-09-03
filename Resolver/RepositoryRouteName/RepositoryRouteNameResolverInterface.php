<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Resolver\RepositoryRouteName;

use RomaricDrigon\OrchestraBundle\Domain\Repository\RepositoryInterface;

/**
 * Interface RepositoryRouteNameResolverInterface
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
interface RepositoryRouteNameResolverInterface
{
    const NAME_PREFIX = 'orchestra_repository';

    /**
     * @param RepositoryInterface $repository
     * @param string $methodName
     * @return string
     */
    public function getRouteName(RepositoryInterface $repository, $methodName);
} 