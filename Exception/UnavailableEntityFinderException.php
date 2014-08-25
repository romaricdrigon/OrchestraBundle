<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Exception;

/**
 * Class UnavailableEntityFinderException
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class UnavailableEntityFinderException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Orchestra EntityFinder is unavailable');
    }
} 