<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Core\Repository\Action;

/**
 * Interface RepositoryActionInterface
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
interface RepositoryActionInterface
{
    /**
     * @return string method name of the action
     */
    public function getMethod();

    /**
     * @return string name
     */
    public function getName();

    /**
     * @return string
     */
    public function getSlug();

    /**
     * @return string
     */
    public function getRouteName();

    /**
     * @return bool Is it the "listing" mandatory method?
     */
    public function isListing();

    /**
     * @return bool is it Command action?
     */
    public function isCommand();

    /**
     * @return null|string
     */
    public function getCommandClass();
}
