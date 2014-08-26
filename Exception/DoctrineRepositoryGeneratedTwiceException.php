<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Exception;

/**
 * Class DoctrineRepositoryGeneratedTwiceException
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class DoctrineRepositoryGeneratedTwiceException extends \Exception
{
    public function __construct($doctrineEntityName)
    {
        parent::__construct('Error: trying to construct twice a repository for Doctrine entity '.$doctrineEntityName);
    }
} 