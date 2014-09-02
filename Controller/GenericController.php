<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Controller;

use RomaricDrigon\OrchestraBundle\Core\Entity\EntityReflectionInterface;
use RomaricDrigon\OrchestraBundle\Domain\Entity\ListableInterface;
use RomaricDrigon\OrchestraBundle\Domain\Repository\RepositoryInterface;
use RomaricDrigon\OrchestraBundle\Exception\Domain\EntityNotListableException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class GenericController
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 *
 * "Base" controller our Request goes to
 */
class GenericController extends Controller
{
    /**
     * Action for the dashboard page
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function dashboardAction()
    {
        return $this->render('RomaricDrigonOrchestraBundle:Generic:dashboard.html.twig', []);
    }

    /**
     * Action used when a repository "listing" is called
     *
     * @param RepositoryInterface $repository
     * @param EntityReflectionInterface $entity
     * @throws EntityNotListableException
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(RepositoryInterface $repository, EntityReflectionInterface $entity)
    {
        $name = $this->get('orchestra.resolver.repository_name')->getName($repository);

        if (! $entity instanceof ListableInterface) {
            throw new EntityNotListableException($entity->getName());
        }

        // Get objects to show
        $objects = $repository->listing();

        // Do not use empty, Doctrine Collection does not support it, only count
        $noData = (count($objects) === 0);

        // We will also need titles for our table header
        // TODO

        // Finally, we need the routes for each entity
        // TODO

        return $this->render('RomaricDrigonOrchestraBundle:Generic:list.html.twig', [
            'headers'   => [],
            'no_data'   => $noData,
            'objects'   => $objects,
            'title'     => $name
        ]);
    }

    /**
     * Action used when a method on en Entity is called
     *
     * @param EntityReflectionInterface $entity
     * @param string $entity_slug
     * @param string $entity_method name
     * @param string $method_slug
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function entityMethodAction(EntityReflectionInterface $entity, $entity_slug, $entity_method, $method_slug)
    {
        return $this->render('RomaricDrigonOrchestraBundle:Generic:dashboard.html.twig', []);
    }
}