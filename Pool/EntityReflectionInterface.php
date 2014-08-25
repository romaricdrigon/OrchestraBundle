<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Pool;

/**
 * Interface EntityReflectionInterface
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
interface EntityReflectionInterface
{
    /**
     * @return \ReflectionClass
     */
    public function getReflectionClass();
} 