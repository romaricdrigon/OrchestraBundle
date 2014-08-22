<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Exception;

/**
 * Class RepositoryNotFoundException
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class RepositoryNotFoundException extends \Exception
{
    public function __construct($slug)
    {
        parent::__construct('Unable to find repository for slug '.$slug.'. Maybe you forget to register it as a service with the the "orchestra.repository" tag?');
    }
}