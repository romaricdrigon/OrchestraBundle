<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Core\Repository\Action;

/**
 * Class RepositoryAction
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class RepositoryAction implements RepositoryActionInterface
{
    /**
     * @var string
     */
    protected $method;

    /**
     * @var string
     */
    protected $name;

    /**
     * @param string $method
     * @param string $name
     */
    public function __construct($method, $name)
    {
        $this->method = $method;
        $this->name = $name;
    }

    /**
     * @inheritdoc
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->name;
    }
} 