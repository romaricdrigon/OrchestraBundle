<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Exception\Request;

/**
 * Class UnsupportedRequestTypeException
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class UnsupportedTypeException extends \Exception
{
    public function __construct($type)
    {
        parent::__construct('Request has an orchestra_type, but type "'.$type.'" is not supported');
    }
} 