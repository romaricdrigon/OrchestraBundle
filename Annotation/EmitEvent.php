<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Annotation;

/**
 * Class EmitEvent
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 *
 * @Annotation
 */
class EmitEvent extends AbstractAnnotation
{
    /**
     * @inheritdoc
     */
    protected function getValueProperty()
    {
        return false; // We have no value
    }
}
