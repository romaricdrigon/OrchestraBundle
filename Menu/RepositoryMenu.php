<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Menu;

use RomaricDrigon\OrchestraBundle\Core\Pool\RepositoryPoolInterface;
use RomaricDrigon\OrchestraBundle\Core\Repository\Action\RepositoryActionCollectionBuilderInterface;
use RomaricDrigon\OrchestraBundle\Core\Repository\Action\RepositoryActionCollectionInterface;

/**
 * Class RepositoryMenu
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class RepositoryMenu implements RepositoryMenuInterface
{
    /**
     * @var \RomaricDrigon\OrchestraBundle\Core\Pool\RepositoryPoolInterface
     */
    protected $repositoryPool;

    /**
     * @var \RomaricDrigon\OrchestraBundle\Core\Repository\Action\RepositoryActionCollectionBuilderInterface
     */
    protected $repositoryActionCollectionBuilder;

    /**
     * @return RepositoryActionCollectionInterface[] keys are repository slug
     */
    protected $menu;


    /**
     * @param RepositoryPoolInterface $repositoryPool
     * @param RepositoryActionCollectionBuilderInterface $repositoryActionCollectionBuilder
     */
    public function __construct(RepositoryPoolInterface $repositoryPool, RepositoryActionCollectionBuilderInterface $repositoryActionCollectionBuilder)
    {
        $this->repositoryPool = $repositoryPool;
        $this->repositoryActionCollectionBuilder = $repositoryActionCollectionBuilder;
    }

    /**
     * @inheritdoc
     */
    public function getMenu()
    {
        if (! $this->menu) {
            $this->buildMenu();
        }

        return $this->menu;
    }

    /**
     * @return RepositoryActionCollectionInterface[]
     */
    protected function buildMenu()
    {
        $repositoryDefinitions = $this->repositoryPool->all();

        foreach ($repositoryDefinitions as $slug => $repositoryDefinition) {
            $this->menu[$slug] = $this->repositoryActionCollectionBuilder->build($repositoryDefinition);
        }
    }
}
