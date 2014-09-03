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
class RepositoryActionCollection implements RepositoryActionCollectionInterface, \IteratorAggregate
{
    /**
     * @var RepositoryActionInterface[]
     */
    protected $actions = [];

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
    public function getIterator() {
        return new \ArrayIterator($this->actions);
    }
} 