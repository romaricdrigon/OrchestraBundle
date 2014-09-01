<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Core\Pool;

/**
 * Interface EntityPoolFactoryInterface
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
interface EntityPoolFactoryInterface
{
    /**
     * Creates a built EntityPool
     *
     * @return EntityPoolInterface
     */
    public function createPool();

    /**
     * Add entities found by EntityFinder to the Pool
     *
     * @param EntityPoolInterface $pool
     * @return EntityPoolInterface
     */
    public function buildPool(EntityPoolInterface $pool);
}