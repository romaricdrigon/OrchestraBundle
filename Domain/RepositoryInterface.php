<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Domain;

/**
 * Interface RepositoryInterface
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 *
 * Interface that repositories used by OrchestraBundle must implement
 */
interface RepositoryInterface
{
    /**
     * Returns all objects of associated class
     *
     * @return array
     */
    public function all();
}