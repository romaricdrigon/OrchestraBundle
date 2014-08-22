<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Exception;

/**
 * Class RepositoryAddedTwiceException
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class RepositoryAddedTwiceException extends \Exception
{
    public function __construct($slug)
    {
        parent::__construct('Repository with slug '.$slug.' seems to be registered twice!');
    }
} 