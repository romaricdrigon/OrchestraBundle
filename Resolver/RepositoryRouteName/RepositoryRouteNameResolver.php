<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Resolver\RepositoryRouteName;

use RomaricDrigon\OrchestraBundle\Domain\Repository\RepositoryInterface;
use RomaricDrigon\OrchestraBundle\Resolver\RepositorySlug\RepositorySlugResolverInterface;

/**
 * Class RepositoryRouteNameResolver
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class RepositoryRouteNameResolver implements RepositoryRouteNameResolverInterface
{
    /**
     * @var RepositorySlugResolverInterface
     */
    protected $repositorySlugResolver;

    /**
     * @param RepositorySlugResolverInterface $repositorySlugResolver
     */
    public function __construct(RepositorySlugResolverInterface $repositorySlugResolver)
    {
        $this->repositorySlugResolver = $repositorySlugResolver;
    }

    /**
     * @inheritdoc
     */
    public function getRouteName(RepositoryInterface $repository, $methodName)
    {
        $slug = $this->repositorySlugResolver->getSlug($repository);

        return $this::NAME_PREFIX.'_'.$slug.'_'.strtolower($methodName);
    }
} 