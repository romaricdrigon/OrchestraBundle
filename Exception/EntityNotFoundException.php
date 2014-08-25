<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Exception;

/**
 * Class EntityNotFoundException
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class EntityNotFoundException extends \Exception
{
    public function __construct($slug)
    {
        parent::__construct('Unable to find entity for slug '.$slug.'!');
    }
} 