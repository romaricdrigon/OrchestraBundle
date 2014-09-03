<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Exception\Domain;

/**
 * Class RepositoryInvalidException
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class RepositoryInvalidException extends \Exception
{
    public function __construct($repoName)
    {
        parent::__construct('Repository '.$repoName.' seems to be invalid. Does it implements RepositoryInterface, and has a "listing" action?');
    }
} 