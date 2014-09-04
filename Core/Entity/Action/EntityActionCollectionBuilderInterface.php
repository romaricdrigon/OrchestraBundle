<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Core\Entity\Action;

use RomaricDrigon\OrchestraBundle\Core\Entity\EntityReflectionInterface;

/**
 * Interface EntityActionCollectionBuilderInterface
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
interface EntityActionCollectionBuilderInterface
{
    /**
     * @param EntityReflectionInterface $entityReflection
     * @return EntityActionCollectionInterface
     */
    public function build(EntityReflectionInterface $entityReflection);
} 