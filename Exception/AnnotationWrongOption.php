<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Exception;

/**
 * Class AnnotationWrongOption
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class AnnotationWrongOption extends \Exception
{
    public function __construct($annotationName, $option)
    {
        parent::__construct('Annotation '.$annotationName.' does not have a '.$option.' option');
    }
} 