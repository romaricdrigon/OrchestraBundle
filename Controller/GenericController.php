<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Controller;

use RomaricDrigon\OrchestraBundle\Core\Entity\EntityReflectionInterface;
use RomaricDrigon\OrchestraBundle\Domain\Command\CommandInterface;
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

        if (false === $entity->isListable()) {
            throw new EntityNotListableException($entity->getName());
        }

        // Get objects to show
        $objects = $repository->listing();

        // Do not use empty, Doctrine Collection does not support it, only count
        $noData = (0 === count($objects));

        // We will also need titles for our table header
        $headers = [];
        if (false === $noData) {
            $headers = $this->get('orchestra.resolver.listing_header')->getHeaders($objects[0], 'viewListing');
        }

        // Finally, we need the routes for each entity
        // TODO

        return $this->render('RomaricDrigonOrchestraBundle:Generic:list.html.twig', [
            'headers'   => $headers,
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

    /**
     * Action used when a method on en Repository is called
     *
     * @param \RomaricDrigon\OrchestraBundle\Domain\Repository\RepositoryInterface $repository
     * @param EntityReflectionInterface $entity
     * @param string $repository_method
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function repositoryMethodAction(RepositoryInterface $repository, EntityReflectionInterface $entity, $repository_method)
    {
        return $this->render('RomaricDrigonOrchestraBundle:Generic:dashboard.html.twig', []);
    }

    /**
     * Action used when a method accepting a Command, on en Repository is called
     *
     * @param \RomaricDrigon\OrchestraBundle\Domain\Repository\RepositoryInterface $repository
     * @param EntityReflectionInterface $entity
     * @param string $repository_method
     * @param CommandInterface $command
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function repositoryCommandAction(RepositoryInterface $repository, EntityReflectionInterface $entity, $repository_method, CommandInterface $command)
    {
        return $this->render('RomaricDrigonOrchestraBundle:Generic:dashboard.html.twig', []);
    }
}