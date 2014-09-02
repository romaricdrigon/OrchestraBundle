<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Exception\Domain;

/**
 * Class EntityNotListableException
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class EntityNotListableException extends \Exception
{
    public function __construct($entityName)
    {
        parent::__construct('Entity '.$entityName.' is not listable. Maybe you forgot to implement ListableInterface?');
    }
} 