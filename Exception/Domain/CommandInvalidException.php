<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Exception\Domain;

/**
 * Class CommandInvalidException
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class CommandInvalidException extends \Exception
{
    public function __construct($command)
    {
        parent::__construct('Received an invalid Command: '.is_object($command) ? get_class($command) : gettype($command));
    }
} 