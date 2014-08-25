<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Menu;

use Knp\Menu\FactoryInterface;
use RomaricDrigon\OrchestraBundle\Getter\RepositoryNameGetter;
use RomaricDrigon\OrchestraBundle\Getter\RepositoryNameGetterInterface;
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
     * @var RepositoryNameGetterInterface
     */
    protected $repositoryNameGetter;

    /**
     * @param FactoryInterface $factory
     * @param RepositoryPoolInterface $repositoryPool
     * @param RepositoryRouteBuilderInterface $repositoryRouteBuilder
     * @param RepositoryNameGetterInterface $repositoryNameGetter
     */
    public function __construct(FactoryInterface $factory, RepositoryPoolInterface $repositoryPool, RepositoryRouteBuilderInterface $repositoryRouteBuilder, RepositoryNameGetterInterface $repositoryNameGetter)
    {
        $this->factory  = $factory;
        $this->repositoryPool   = $repositoryPool;
        $this->repositoryRouteBuilder   = $repositoryRouteBuilder;
        $this->repositoryNameGetter     = $repositoryNameGetter;
    }

    public function createMainMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');

        $repositories = $this->repositoryPool->all();

        foreach ($repositories as $slug => $repository) {
            $name = $this->repositoryNameGetter->getName($repository);
            $routeName = $this->repositoryRouteBuilder->buildRouteName($slug);

            $menu->addChild($name, ['route' => $routeName]);
        }

        return $menu;
    }
}