<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Exception\Request;

/**
 * Class MissingAttributeException
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class MissingAttributeException extends \Exception
{
    public function __construct($attribute)
    {
        parent::__construct('Request is missing attribute '.$attribute);
    }
} 