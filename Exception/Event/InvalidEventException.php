<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Exception\Event;

/**
 * Class NoEventEmitted
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class InvalidEventException extends \Exception
{
    public function __construct($entityName, $entityMethod)
    {
        parent::__construct('An invalid Event was emitted by '.$entityName.' '.$entityMethod.'. Maybe you forgot to implement EventInterface? Result must be either an implementation either null.');
    }
} 