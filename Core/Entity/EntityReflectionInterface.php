<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Core\Entity;

/**
 * Interface EntityReflectionInterface
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
interface EntityReflectionInterface
{
    /**
     * @return string
     */
    public function getSlug();

    /**
     * @return \ReflectionMethod[] list of public methods from class, keys are slugs
     */
    public function getMethods();

    /**
     * @param string $methodName
     * @return \ReflectionMethod
     */
    public function getMethod($methodName);

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string Entity class name with its full namespace
     */
    public function getNamespacedName();

    /**
     * @return bool
     */
    public function isListable();
}
