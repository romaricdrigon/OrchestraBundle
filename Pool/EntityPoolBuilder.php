<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Pool;

use RomaricDrigon\OrchestraBundle\Finder\EntityFinderInterface;

/**
 * Class EntityPoolBuilder
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class EntityPoolBuilder implements EntityPoolBuilderInterface
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
    public function buildPool(EntityPoolInterface $pool)
    {
        $reflections = $this->entityFinder->getEntitiesReflections();

        foreach ($reflections as $reflection) {
            $pool->addEntityReflection($reflection);
        }

        return $pool;
    }
} 