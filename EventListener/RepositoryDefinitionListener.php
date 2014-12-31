<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\DependencyInjection\ContainerInterface;
use RomaricDrigon\OrchestraBundle\Core\Repository\RepositoryDefinitionInterface;

/**
 * Class RepositoryDefinitionListener
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class RepositoryDefinitionListener implements EventSubscriberInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Our subscriber priority
     * Before ParamConverter listener
     */
    const PRIORITY = 600;


    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return [KernelEvents::CONTROLLER => ['onKernelController', self::PRIORITY]];
    }

    /**
     * We need the container are we will access a service at runtime
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param FilterControllerEvent $event
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $request = $event->getRequest();

        if (! $request->attributes->has('repository_definition')) {
            return;
        }

        /** @var RepositoryDefinitionInterface $repositoryDefinition */
        $repositoryDefinition = $request->attributes->get('repository_definition');

        $repository = $this->container->get($repositoryDefinition->getServiceId());

        $request->attributes->set('repository', $repository);
    }
}
