<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Controller;

use Doctrine\ORM\EntityNotFoundException;
use RomaricDrigon\OrchestraBundle\Core\Entity\EntityReflectionInterface;
use RomaricDrigon\OrchestraBundle\Domain\Command\CommandInterface;
use RomaricDrigon\OrchestraBundle\Domain\Entity\EntityInterface;
use RomaricDrigon\OrchestraBundle\Domain\Repository\RepositoryInterface;
use RomaricDrigon\OrchestraBundle\Exception\Domain\EntityNotListableException;
use RomaricDrigon\OrchestraBundle\Form\Type\CommandType;
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
    public function entityMethodAction(EntityReflectionInterface $entity, EntityInterface $object = null, $entity_method)
    {
        // TODO: we may (must ?) return a Query

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
        // TODO: we may (must ?) return a Query

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
        $form = $this->createForm(new CommandType($command), $command);

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


        $form = $this->createForm(new CommandType($command), $command);

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
     * Small helper
     *
     * @return ObjectManagerInterface
     */
    protected function getObjectManager()
    {
        return $this->get('orchestra.doctrine.object_manager');
    }
}