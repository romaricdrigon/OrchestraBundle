<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Pool;

/**
 * Interface EntityPoolInterface
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
interface EntityPoolInterface
{
    /**
     * Add an entity to the pool
     *
     * @param \ReflectionClass $entityReflection
     */
    public function addEntityReflection(\ReflectionClass $entityReflection);

    /**
     * Get an entity from by slug
     *
     * @param string $slug
     * @return \ReflectionClass
     */
    public function getBySlug($slug);

    /**
     * @return array all entities indexed by slug
     */
    public function all();
} 