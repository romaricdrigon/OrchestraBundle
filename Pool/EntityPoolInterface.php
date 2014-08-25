<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Pool;

use RomaricDrigon\OrchestraBundle\Domain\EntityInterface;

/**
 * Interface EntityPoolInterface
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
interface EntityPoolInterface
{
    /**
     * Add an entity to the pool
     *
     * @param EntityInterface $entity
     */
    public function addEntity(EntityInterface $entity);

    /**
     * Get an entity from by slug
     *
     * @param string $slug
     * @return EntityInterface
     */
    public function getBySlug($slug);

    /**
     * @return array all entities indexed by slug
     */
    public function all();
} 