<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Exception;

/**
 * Class DomainInvalidException
 * This is a "severe" version of "DomainErrorException", meaning the Domain contains an irremediable modelisation error.
 *
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class DomainInvalidException extends DomainErrorException
{
}
