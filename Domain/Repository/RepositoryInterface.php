<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Domain\Repository;

use RomaricDrigon\OrchestraBundle\Domain\Entity\EntityInterface;

/**
 * Interface RepositoryInterface
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 *
 * Interface that repositories used by OrchestraBundle must implement
 */
interface RepositoryInterface
{
    /**
     * Method used by "list" page ("list" is a PHP reserved keyword)
     * Usually returns all instances of given type
     * You may want to customize this, or which fields are displayed
     *
     * @return array
     */
    public function listing();

    /**
     * Provide a way to fetch an entity
     * Receive an ID, the same than returned by the entity getId()
     *
     * @param mixed $id
     * @return EntityInterface|null
     */
    public function find($id);
}
