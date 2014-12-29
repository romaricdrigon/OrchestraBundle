<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Domain\Event;

/**
 * Interface EventCollectionInterface
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
interface EventCollectionInterface extends \Countable, \IteratorAggregate
{
    /**
     * @param EventInterface $event
     * @return $this
     */
    public function add(EventInterface $event);

    /**
     * Get last Event and remove it from the array
     *
     * @return EventInterface
     */
    public function pop();

    /**
     * Get first Event and remove it from the array
     *
     * @return EventInterface
     */
    public function shift();
}
