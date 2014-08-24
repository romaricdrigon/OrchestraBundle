<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Menu;

use Knp\Menu\FactoryInterface;
use RomaricDrigon\OrchestraBundle\Pool\RepositoryPoolInterface;
use RomaricDrigon\OrchestraBundle\Routing\RepositoryRouteBuilderInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class MenuBuilder
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class MenuBuilder
{
    /**
     * @var FactoryInterface
     */
    protected $factory;

    /**
     * @var RepositoryPoolInterface
     */
    protected $repositoryPool;

    /**
     * @var RepositoryRouteBuilderInterface
     */
    protected $repositoryRouteBuilder;

    /**
     * @param FactoryInterface $factory
     * @param RepositoryPoolInterface $repositoryPool
     * @param RepositoryRouteBuilderInterface $repositoryRouteBuilder
     */
    public function __construct(FactoryInterface $factory, RepositoryPoolInterface $repositoryPool, RepositoryRouteBuilderInterface $repositoryRouteBuilder)
    {
        $this->factory  = $factory;
        $this->repositoryPool   = $repositoryPool;
        $this->repositoryRouteBuilder = $repositoryRouteBuilder;
    }

    public function createMainMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');

        $repositories = $this->repositoryPool->all();

        foreach ($repositories as $slug => $repository) {
            $menu->addChild($slug, ['route' => $this->repositoryRouteBuilder->buildRouteName($slug)]);
        }

        return $menu;
    }
}