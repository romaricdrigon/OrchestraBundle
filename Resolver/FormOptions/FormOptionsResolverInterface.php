<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Resolver\FormOptions;

use RomaricDrigon\OrchestraBundle\Annotation\FormType;
/**
 * Interface CommandFactoryResolverInterface
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
interface FormOptionsResolverInterface
{
    /**
     * @param \ReflectionProperty $reflectionProperty
     * @return FormType|array
     */
    public function getFormOptions(\ReflectionProperty $reflectionProperty);
}
