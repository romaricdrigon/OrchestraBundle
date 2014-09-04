<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Core\Entity\Action;

/**
 * Class EntityActionCollection
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class EntityActionCollection implements \IteratorAggregate, EntityActionCollectionInterface
{
    /**
     * @var EntityActionInterface[]
     */
    protected $actions = [];


    /**
     * @inheritdoc
     */
    public function addAction(EntityActionInterface $entityAction)
    {
        $this->actions[] = $entityAction;

        return $this;
    }

    /**
     * Required by \IteratorAggregate, so we can iterate over this collection
     *
     * @inheritdoc
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->actions);
    }

    /**
     * Required by \Countable
     *
     * @inheritdoc
     */
    public function count()
    {
        return count($this->actions);
    }
} 