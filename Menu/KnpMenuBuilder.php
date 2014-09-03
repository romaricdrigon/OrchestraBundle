<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Menu;

use Knp\Menu\FactoryInterface;
use RomaricDrigon\OrchestraBundle\Resolver\RepositoryNameResolverInterface;
use RomaricDrigon\OrchestraBundle\Core\Pool\RepositoryPoolInterface;
use RomaricDrigon\OrchestraBundle\Routing\RepositoryRouteBuilderInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class KnpMenuBuilder
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class KnpMenuBuilder
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
     * @var RepositoryNameResolverInterface
     */
    protected $repositoryNameResolver;

    /**
     * @param FactoryInterface $factory
     * @param RepositoryPoolInterface $repositoryPool
     * @param RepositoryRouteBuilderInterface $repositoryRouteBuilder
     * @param RepositoryNameResolverInterface $repositoryNameResolver
     */
    public function __construct(FactoryInterface $factory, RepositoryPoolInterface $repositoryPool, RepositoryRouteBuilderInterface $repositoryRouteBuilder, RepositoryNameResolverInterface $repositoryNameResolver)
    {
        $this->factory  = $factory;
        $this->repositoryPool   = $repositoryPool;
        $this->repositoryRouteBuilder   = $repositoryRouteBuilder;
        $this->repositoryNameResolver   = $repositoryNameResolver;
    }

    /**
     * Creates the "main" menu, the one on top of every page
     *
     * @param Request $request
     * @return \Knp\Menu\ItemInterface
     */
    public function createMainMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');

        $repositories = $this->repositoryPool->all();

        foreach ($repositories as $slug => $repository) {
            $name = $this->repositoryNameResolver->getName($repository);
            $routeName = $this->repositoryRouteBuilder->buildRouteName($slug);

            $menu->addChild($name, ['route' => $routeName]);
        }

        return $menu;
    }
}