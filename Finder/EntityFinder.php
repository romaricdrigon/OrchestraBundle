<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Finder;

use RomaricDrigon\OrchestraBundle\Pool\EntityReflection;

/**
 * Class EntityFinder
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class EntityFinder implements EntityFinderInterface
{
    /**
     * @var EntityLoaderInterface
     */
    protected $entityLoader;


    public function __construct(EntityLoaderInterface $entityLoader)
    {
        $this->entityLoader = $entityLoader;
    }

    /**
     * @inheritdoc
     */
    public function getEntitiesReflections()
    {
        $potentialEntities = $this->entityLoader->load();

        $entities = [];

        foreach ($potentialEntities as $className) {
            $reflection = new \ReflectionClass($className);

            // Order of checks is important here for optimization purpose
            if ($reflection->implementsInterface('RomaricDrigon\OrchestraBundle\Domain\EntityInterface')) {
                $entities[] = new EntityReflection($reflection);
            }
        }

        return $entities;
    }
} 