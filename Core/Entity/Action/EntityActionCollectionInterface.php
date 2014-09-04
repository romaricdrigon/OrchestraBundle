<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Core\Entity\Action;

/**
 * Interface EntityActionCollectionInterface
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
interface EntityActionCollectionInterface extends \Traversable, \Countable
{
    /**
     * @param EntityActionInterface $entityAction
     * @return $this
     */
    public function addAction(EntityActionInterface $entityAction);
} 