<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Pool;

use RomaricDrigon\OrchestraBundle\Domain\EntityInterface;
use RomaricDrigon\OrchestraBundle\Exception\EntityAddedTwiceException;
use RomaricDrigon\OrchestraBundle\Exception\EntityNotFoundException;

/**
 * Class EntityPool
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class EntityPool implements EntityPoolInterface
{
    protected $entitiesBySlug = [];

    /**
     * Add an entity to the pool
     *
     * @param EntityInterface $entity
     * @throws EntityAddedTwiceException
     */
    public function addEntity(EntityInterface $entity)
    {
        // At the moment slug is not configurable otherwise
        $reflect = new \ReflectionClass($entity);
        $slug = strtolower($reflect->getShortName());

        if (isset($this->entitiesBySlug[$slug])) {
            throw new EntityAddedTwiceException($slug);
        }

        $this->entitiesBySlug[$slug] = $entity;
    }

    /**
     * Get an entity from by slug
     *
     * @param string $slug
     * @throws EntityNotFoundException
     * @return EntityInterface
     */
    public function getBySlug($slug)
    {
        if (! isset($this->entitiesBySlug[$slug])) {
            throw new EntityNotFoundException($slug);
        }

        return $this->entitiesBySlug[$slug];
    }

    /**
     * @inheritdoc
     */
    public function all()
    {
        return $this->entitiesBySlug;
    }
} 