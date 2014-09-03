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
     * @param string $method
     * @param string $name
     * @param string $routeName
     */
    public function __construct($method, $name, $routeName)
    {
        $this->method = $method;
        $this->name = $name;
        $this->routeName = $routeName;

        $this->slug = strtolower($method);
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
    public function isListing()
    {
        return ($this->method === 'listing');
    }
} 