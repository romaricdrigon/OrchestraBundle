<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Exception;

/**
 * Class EntityTwiceSameSlugException
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class EntityTwiceSameSlugException extends \Exception
{
    public function __construct($entityName, $slug)
    {
        parent::__construct('Entity '.$entityName.' has 2 methods with the same slug '.$slug);
    }
} 