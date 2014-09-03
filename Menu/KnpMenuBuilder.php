<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Menu;

use Knp\Menu\FactoryInterface;
use RomaricDrigon\OrchestraBundle\Exception\Domain\RepositoryInvalidException;
use RomaricDrigon\OrchestraBundle\Core\Repository\Action\RepositoryActionInterface;
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
     * @var RepositoryMenuInterface
     */
    protected $repositoryMenu;


    /**
     * @param FactoryInterface $factory
     * @param RepositoryMenuInterface $repositoryMenu
     */
    public function __construct(FactoryInterface $factory, RepositoryMenuInterface $repositoryMenu)
    {
        $this->factory  = $factory;
        $this->repositoryMenu   = $repositoryMenu;
    }

    /**
     * Creates the "main" menu, the one on top of every page
     *
     * @param Request $request
     * @throws \RomaricDrigon\OrchestraBundle\Exception\Domain\RepositoryInvalidException
     * @return \Knp\Menu\ItemInterface
     */
    public function createMainMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');

        $repositoriesMenu = $this->repositoryMenu->getMenu();

        foreach ($repositoriesMenu as $slug => $repositoryActions) {
            // We have at least a "listing" action
            $listing = $repositoryActions->getListingAction();

            if (null === $listing) {
                throw new RepositoryInvalidException($slug);
            }
            $oneRepoMenu = $menu->addChild($listing->getName(), ['route' => $listing->getRouteName()]);

            /** @var RepositoryActionInterface $action */
            foreach ($repositoryActions as $action) {
                $oneRepoMenu->addChild($action->getName(), ['route' => $action->getRouteName()]);
            }
        }

        return $menu;
    }
}