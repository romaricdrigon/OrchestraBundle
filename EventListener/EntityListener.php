<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\EventListener;

use RomaricDrigon\OrchestraBundle\Resolver\EntityRepository\EntityRepositoryResolverInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class EntityListener
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class EntityListener implements EventSubscriberInterface
{
    /**
     * @var EntityRepositoryResolverInterface
     */
    protected $entityRepositoryResolver;

    /**
     * Our subscriber priority
     */
    const PRIORITY = 850;


    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return [KernelEvents::CONTROLLER => ['onKernelController', self::PRIORITY]];
    }

    /**
     * @param EntityRepositoryResolverInterface $entityRepositoryResolver
     */
    public function __construct(EntityRepositoryResolverInterface $entityRepositoryResolver)
    {
        $this->entityRepositoryResolver = $entityRepositoryResolver;
    }

    /**
     * @param FilterControllerEvent $event
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $request = $event->getRequest();

        if (! $request->attributes->has('entity')) {
            return;
        }

        $entity = $request->attributes->get('entity');

        $repositoryDefinition = $this->entityRepositoryResolver->findForEntity($entity);

        $request->attributes->set('repository_definition', $repositoryDefinition);
    }
}
