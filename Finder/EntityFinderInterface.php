<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Finder;

use RomaricDrigon\OrchestraBundle\Core\Entity\EntityReflectionInterface;

/**
 * Interface EntityFinderInterface
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
interface EntityFinderInterface
{
    /**
     * @return EntityReflectionInterface[] returns all valid entities
     */
    public function getEntitiesReflections();
}
