<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Exception;

/**
 * Class LoaderAddedTwiceException
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class LoaderAddedTwiceException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Do not add the "orchestra" loader more than once!');
    }
} 