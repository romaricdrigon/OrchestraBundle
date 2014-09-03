<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

/**
 * Class CommandResolverListener
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class CommandResolverListener implements EventSubscriberInterface
{
    /**
     * Our subscriber priority
     */
    const PRIORITY = 750;

    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return [KernelEvents::CONTROLLER => ['onKernelController', self::PRIORITY]];
    }

    /**
     * @param FilterControllerEvent $event
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $request = $event->getRequest();

        // First, check if it's an Orchestra with a Command request
        // This listener can deal both with entities and repositories
        if (! $request->attributes->has('command_class')) {
            return;
        }

        $commandClass = $request->attributes->get('command_class');

        $reflection = new \ReflectionClass($commandClass);

        $command = $reflection->newInstanceWithoutConstructor();

        $request->attributes->set('command', $command);
    }
}