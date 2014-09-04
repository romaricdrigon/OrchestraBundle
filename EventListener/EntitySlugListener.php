<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\EventListener;

use RomaricDrigon\OrchestraBundle\Core\Pool\EntityPoolInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class EntitySlugListener
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class EntitySlugListener implements EventSubscriberInterface
{
    /**
     * @var EntityPoolInterface
     */
    protected $entityPool;

    /**
     * Our subscriber priority
     */
    const PRIORITY = 950;

    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return [KernelEvents::CONTROLLER => ['onKernelController', self::PRIORITY]];
    }

    public function __construct(EntityPoolInterface $entityPool)
    {
        $this->entityPool = $entityPool;
    }

    /**
     * @param FilterControllerEvent $event
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $request = $event->getRequest();

        if (! $request->attributes->has('entity_slug')) {
            return;
        }

        $slug = $request->attributes->get('entity_slug');

        $entity = $this->entityPool->getBySlug($slug);

        $request->attributes->set('entity', $entity);
    }
} 