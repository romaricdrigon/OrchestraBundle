<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Core\Pool\Factory;

use RomaricDrigon\OrchestraBundle\Finder\EntityFinderInterface;
use RomaricDrigon\OrchestraBundle\Core\Pool\EntityPoolInterface;
use RomaricDrigon\OrchestraBundle\Core\Pool\EntityPool;

/**
 * Class EntityPoolFactory
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class EntityPoolFactory implements EntityPoolFactoryInterface
{
    /**
     * @var EntityFinderInterface
     */
    protected $entityFinder;

    public function __construct(EntityFinderInterface $entityFinder)
    {
        $this->entityFinder = $entityFinder;
    }

    /**
     * @inheritdoc
     */
    public function createPool()
    {
        $pool = new EntityPool();

        return $this->buildPool($pool);
    }

    /**
     * @inheritdoc
     */
    public function buildPool(EntityPoolInterface $pool)
    {
        $reflections = $this->entityFinder->getEntitiesReflections();

        foreach ($reflections as $reflection) {
            $pool->addEntityReflection($reflection);
        }

        return $pool;
    }
}
