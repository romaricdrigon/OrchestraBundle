<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Core\Entity\Action;

/**
 * Class EntityAction
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class EntityAction implements EntityActionInterface
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
     * @var bool
     */
    protected $emitEvent;


    /**
     * @param string $method
     * @param string $name
     * @param string $routeName
     * @param string $slug
     * @param string|null $command
     * @param bool $emitEvent
     */
    public function __construct($method, $name, $routeName, $slug, $command = null, $emitEvent = false)
    {
        $this->method   = $method;
        $this->name     = $name;
        $this->routeName = $routeName;
        $this->slug     = $slug;
        $this->command  = $command;
        $this->emitEvent = $emitEvent;
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
    public function emitEvent()
    {
        return $this->emitEvent;
    }

    /**
     * @inheritdoc
     */
    public function getCommandClass()
    {
        return $this->command;
    }
}
