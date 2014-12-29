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
use RomaricDrigon\OrchestraBundle\Domain\Entity\EntityInterface;
use RomaricDrigon\OrchestraBundle\Domain\Event\EventInterface;
use RomaricDrigon\OrchestraBundle\Domain\Repository\ReceiveEventInterface;
use RomaricDrigon\OrchestraBundle\Domain\Repository\RepositoryInterface;
use RomaricDrigon\OrchestraBundle\Exception\DomainErrorException;
use RomaricDrigon\OrchestraBundle\Exception\Event\InvalidEventException;
use RomaricDrigon\OrchestraBundle\Exception\Event\RepositoryNotEnabledException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use RomaricDrigon\OrchestraBundle\Doctrine\ObjectManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     * @throws DomainErrorException
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction(RepositoryInterface $repository, EntityReflectionInterface $entity)
    {
        $name = $this->get('orchestra.resolver.repository_name')->getName($repository);

        if (false === $entity->isListable()) {
            throw new DomainErrorException('Entity '.$entity->getName().' is not listable. Maybe you forgot to implement ListableInterface?');
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
        $actions = $this->get('orchestra.core_entity.action_collection_builder')->build($entity);

        return $this->render('RomaricDrigonOrchestraBundle:Generic:list.html.twig', [
            'actions'   => $actions,
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
     * @param EntityInterface|null $object
     * @param string $entity_method name
     * @internal param string $entity_slug
     * @internal param string $method_slug
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function entityQueryAction(EntityReflectionInterface $entity, EntityInterface $object = null, $entity_method)
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
    public function repositoryQueryAction(RepositoryInterface $repository, EntityReflectionInterface $entity, $repository_method)
    {
        return $this->render('RomaricDrigonOrchestraBundle:Generic:dashboard.html.twig', []);
    }

    /**
     * Action used when a method accepting a Command, on en Repository is called
     *
     * @param Request $request
     * @param RepositoryInterface $repository
     * @param string $repository_method
     * @param CommandInterface $command
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function repositoryCommandAction(Request $request, RepositoryInterface $repository, $repository_method, CommandInterface $command)
    {
        $form = $this->createForm('orchestra_command_type', $command, [
            'command' => $command
        ]);

        $repoName = $this->get('orchestra.resolver.repository_name')->getName($repository);

        if ($request->isMethod('POST')) {
            if ($form->handleRequest($request) && $form->isValid()) {
                // Pass the command to the repository, and we're done!
                call_user_func([$repository, $repository_method], $command);

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'Command run with success!'
                );

                // We redirect to "listing" page/action
                $listRoute = $this->get('orchestra.resolver.repository_route_name')->getRouteName($repository, 'listing');

                return $this->redirect($this->generateUrl($listRoute));
            } else {
                $this->get('session')->getFlashBag()->add(
                    'error',
                    'An error happened!'
                );
            }
        }

        return $this->render('RomaricDrigonOrchestraBundle:Generic:repositoryCommand.html.twig', [
            'form'  => $form->createView(),
            'title' => $repoName
        ]);
    }

    /**
     * Action used when a method accepting a Command, on en Entity is called
     *
     * @param Request $request
     * @param CommandInterface $command
     * @param EntityReflectionInterface $entity
     * @param string $entity_method
     * @param EntityInterface $object
     * @throws NotFoundHttpException
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function entityCommandAction(Request $request, CommandInterface $command, EntityReflectionInterface $entity, $entity_method, EntityInterface $object = null)
    {
        if (null === $object) {
            throw new NotFoundHttpException();
        }

        $form = $this->createForm('orchestra_command_type', $command, [
            'command' => $command
        ]);

        if ($request->isMethod('POST')) {
            if ($form->handleRequest($request) && $form->isValid()) {
                // Pass the command to the repository, and we're done!
                call_user_func([$object, $entity_method], $command);

                // We have to save the result!
                // We use our provided ObjectManager, not Doctrine
                $this->getObjectManager()->saveObject($object);

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'Command run with success!'
                );
            } else {
                $this->get('session')->getFlashBag()->add(
                    'error',
                    'An error happened!'
                );
            }
        }

        return $this->render('RomaricDrigonOrchestraBundle:Generic:entityCommand.html.twig', [
            'form'  => $form->createView(),
            'title' => $entity->getName().' - '.$entity_method
        ]);
    }

    /**
     * Action used when a method with a "EmitEvent" annotations is called
     *
     * @param EntityReflectionInterface $entity
     * @param string $entity_method
     * @param EntityInterface $object
     * @param RepositoryInterface $repository
     * @throws InvalidEventException
     * @throws NotFoundHttpException
     * @throws RepositoryNotEnabledException
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function entityEventAction(EntityReflectionInterface $entity, $entity_method, EntityInterface $object = null, RepositoryInterface $repository)
    {
        if (null === $object) {
            throw new NotFoundHttpException();
        }

        // Get the Event
        $event = call_user_func([$object, $entity_method]);

        // We accept "null", in that case we do nothing, but no other objects
        if (null !== $event && ! $event instanceof EventInterface) {
            throw new InvalidEventException($entity->getName(), $entity_method);
        }

        if (! $repository instanceof ReceiveEventInterface) {
            throw new RepositoryNotEnabledException($entity->getName());
        }

        if (null !== $event) {
            call_user_func([$repository, 'receive'], $event);

            $this->get('session')->getFlashBag()->add(
                'success',
                'Success!'
            );
        }

        // We redirect to "listing" page/action
        $listRoute = $this->get('orchestra.resolver.repository_route_name')->getRouteName($repository, 'listing');

        return $this->redirect($this->generateUrl($listRoute));
    }

    /**
     * Small helper
     *
     * @return ObjectManagerInterface
     */
    protected function getObjectManager()
    {
        return $this->get('orchestra.doctrine.object_manager');
    }
}