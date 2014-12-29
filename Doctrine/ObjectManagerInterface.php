<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Doctrine;

/**
 * Interface ObjectManagerInterface
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
interface ObjectManagerInterface
{
    /**
     * Save an object state to the database
     *
     * @param $object
     */
    public function saveObject($object);

    /**
     * Remove an object from the database
     *
     * @param $object
     */
    public function removeObject($object);
}
