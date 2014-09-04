<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Resolver\FormType;

use RomaricDrigon\OrchestraBundle\Annotation\FormType;
/**
 * Interface CommandFactoryResolverInterface
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
interface FormTypeResolverInterface
{
    /**
     * @param \ReflectionProperty $reflectionProperty
     * @return FormType|null
     */
    public function getFormType(\ReflectionProperty $reflectionProperty);
} 