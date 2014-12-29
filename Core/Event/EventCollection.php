<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Core\Event;

use RomaricDrigon\OrchestraBundle\Domain\Event\EventCollectionInterface;
use RomaricDrigon\OrchestraBundle\Domain\Event\EventInterface;

/**
 * Class EventCollection
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class EventCollection implements EventCollectionInterface
{
    /**
     * @var EventInterface[]
     */
    protected $events;


    public function __construct()
    {
        $this->events = [];
    }

    /**
     * @inheritdoc
     */
    public function add(EventInterface $event)
    {
        $this->events[] = $event;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function pop()
    {
        return array_pop($this->events);
    }

    /**
     * @inheritdoc
     */
    public function shift()
    {
        return array_shift($this->events);
    }

    /**
     * @inheritdoc
     */
    public function count()
    {
        return count($this->events);
    }

    /**
     * @inheritdoc
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->events);
    }
}
