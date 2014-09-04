<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Exception\Event;

/**
 * Class RepositoryNotEnabledException
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class RepositoryNotEnabledException extends \Exception
{
    public function __construct($entityName)
    {
        parent::__construct('Repository for Entity '.$entityName.' can not receive Events. Maybe you forgot to implement ReceiveEventInterface?');
    }
} 