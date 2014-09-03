<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Resolver\HiddenAction;

/**
 * Interface HiddenActionResolverInterface
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
interface HiddenActionResolverInterface
{
    /**
     * @param object $object
     * @return bool
     */
    public function isHiddenObject($object);

    /**
     * @param \ReflectionMethod $reflectionMethod
     * @return bool
     */
    public function isHiddenReflectionMethod(\ReflectionMethod $reflectionMethod);
} 