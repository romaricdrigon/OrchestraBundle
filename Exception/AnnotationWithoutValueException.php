<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Exception;

/**
 * Class AnnotationWithoutValueException
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class AnnotationWithoutValueException extends \Exception
{
    public function __construct($annotationName)
    {
        parent::__construct('@'.$annotationName.'("value") is not a valid syntax');
    }
}