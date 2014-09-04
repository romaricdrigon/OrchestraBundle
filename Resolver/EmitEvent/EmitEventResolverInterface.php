<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Resolver\EmitEvent;

/**
 * Interface EmitEventResolverInterface
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
interface EmitEventResolverInterface
{
    /**
     * @param \ReflectionMethod $reflectionMethod
     * @return bool
     */
    public function methodEmitsEvent(\ReflectionMethod $reflectionMethod);
} 