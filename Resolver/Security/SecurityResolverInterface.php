<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Resolver\Security;

use Symfony\Component\ExpressionLanguage\Expression;

/**
 * Interface EmitEventResolverInterface
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
interface SecurityResolverInterface
{
    /**
     * @param \ReflectionMethod $reflectionMethod
     * @return Expression|null
     */
    public function getExpression(\ReflectionMethod $reflectionMethod);
} 