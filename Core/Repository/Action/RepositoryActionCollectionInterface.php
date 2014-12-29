<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Core\Repository\Action;

/**
 * Interface RepositoryActionCollection
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
interface RepositoryActionCollectionInterface extends \Traversable, \Countable
{
    /**
     * @param RepositoryActionInterface $repositoryAction
     * @return $this
     */
    public function addAction(RepositoryActionInterface $repositoryAction);

    /**
     * @return null|RepositoryActionInterface
     */
    public function getListingAction();

    /**
     * @return string Repository public name
     */
    public function getName();
}
