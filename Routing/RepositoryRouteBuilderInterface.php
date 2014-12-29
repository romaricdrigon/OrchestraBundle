<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Routing;

use Symfony\Component\Routing\Route;
use RomaricDrigon\OrchestraBundle\Domain\Repository\RepositoryInterface;

/**
 * Interface RepositoryRouteBuilder
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
interface RepositoryRouteBuilderInterface
{
    /**
     * Build a Symfony Route for given repository
     *
     * @param RepositoryInterface $repositoryInterface
     * @param string $slug
     * @return Route[]
     */
    public function buildRoutes(RepositoryInterface $repositoryInterface, $slug);
}
