<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Resolver\RepositoryEntity;

use RomaricDrigon\OrchestraBundle\Pool\EntityPoolInterface;

/**
 * Class ConventionResolver
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class RepositoryEntityResolver implements RepositoryEntityResolverInterface
{
    /**
     * @var EntityPoolInterface
     */
    protected $entityPool;

    public function __construct(EntityPoolInterface $entityPool)
    {
        $this->entityPool = $entityPool;
    }

    /**
     * @inheritdoc
     */
    public function findBySlug($repositorySlug)
    {
        // Pretty simple, uh?
        $entitySlug = $repositorySlug;

        $this->entityPool->getBySlug($entitySlug);
    }
} 