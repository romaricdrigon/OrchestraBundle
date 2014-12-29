<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Core\Repository\Action;

/**
 * Class RepositoryActionCollection
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class RepositoryActionCollection implements \IteratorAggregate, RepositoryActionCollectionInterface
{
    /**
     * @var RepositoryActionInterface[]
     */
    protected $actions = [];

    /**
     * @var string
     */
    protected $name;


    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @inheritdoc
     */
    public function addAction(RepositoryActionInterface $repositoryAction)
    {
        $this->actions[] = $repositoryAction;

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

    /**
     * @inheritdoc
     */
    public function getListingAction()
    {
        foreach ($this->actions as $action) {
            if (true === $action->isListing()) {
                return $action;
            }
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->name;
    }
}
