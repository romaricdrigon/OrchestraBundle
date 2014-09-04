<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Resolver\EntityRepository;

use RomaricDrigon\OrchestraBundle\Core\Pool\RepositoryPoolInterface;
use RomaricDrigon\OrchestraBundle\Core\Entity\EntityReflectionInterface;

/**
 * Class EntityRepositoryResolver
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class EntityRepositoryResolver implements EntityRepositoryResolverInterface
{
    /**
     * @var RepositoryPoolInterface
     */
    protected $repositoryPool;

    /**
     * @param RepositoryPoolInterface $repositoryPool
     */
    public function __construct(RepositoryPoolInterface $repositoryPool)
    {
        $this->repositoryPool = $repositoryPool;
    }

    /**
     * @inheritdoc
     */
    public function findForEntity(EntityReflectionInterface $entityReflection)
    {
        // Pretty simple, uh?
        $repositorySlug = $entityReflection->getSlug();

        return $this->repositoryPool->getBySlug($repositorySlug);
    }
} 