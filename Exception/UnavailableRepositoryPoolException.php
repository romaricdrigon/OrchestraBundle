<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Exception;

/**
 * Class UnavailableRepositoryPoolException
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class UnavailableRepositoryPoolException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Orchestra RepositoryPool is unavailable');
    }
} 