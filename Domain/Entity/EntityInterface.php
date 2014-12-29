<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Domain\Entity;

/**
 * Interface EntityInterface
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
interface EntityInterface
{
    /**
     * @return mixed an ID used to identify an entity instance
     */
    public function getId();
}
