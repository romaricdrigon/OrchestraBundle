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
 * Interface EntityActionBuilderInterface
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
interface EntityActionBuilderInterface
{
    /**
     * @param EntityReflectionInterface $entityReflection
     * @param \ReflectionMethod $reflectionMethod
     * @return EntityActionInterface
     */
    public function build(EntityReflectionInterface $entityReflection, \ReflectionMethod $reflectionMethod);
} 