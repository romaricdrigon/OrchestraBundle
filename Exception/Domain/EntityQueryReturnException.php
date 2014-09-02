<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Exception\Domain;

/**
 * Class EntityQueryReturnException
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class EntityQueryReturnException extends \Exception
{
    public function __construct($entityName, $methodName)
    {
        parent::__construct('Entity '.$entityName.' method '.$methodName.' should return either an array, either an instance of QueryInterface');
    }
} 