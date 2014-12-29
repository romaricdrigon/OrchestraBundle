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
     * @var string
     */
    protected $routeName;

    /**
     * @var string
     */
    protected $slug;

    /**
     * @var null|string
     */
    protected $command;


    /**
     * @param string $method
     * @param string $name
     * @param string $routeName
     * @param string $slug
     * @param string|null $command
     */
    public function __construct($method, $name, $routeName, $slug, $command = null)
    {
        $this->method   = $method;
        $this->name     = $name;
        $this->routeName = $routeName;
        $this->slug     = $slug;
        $this->command  = $command;
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

    /**
     * @inheritdoc
     */
    public function getRouteName()
    {
        return $this->routeName;
    }

    /**
     * @inheritdoc
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @inheritdoc
     */
    public function isCommand()
    {
        return (null !== $this->command);
    }

    /**
     * @inheritdoc
     */
    public function getCommandClass()
    {
        return $this->command;
    }

    /**
     * @inheritdoc
     */
    public function isListing()
    {
        return ($this->method === 'listing');
    }
}
