<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\EventListener;

use RomaricDrigon\OrchestraBundle\Resolver\CommandFactory\CommandFactoryResolverInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use RomaricDrigon\OrchestraBundle\Exception\Request\MissingAttributeException;

/**
 * Class CommandResolverListener
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class CommandResolverListener implements EventSubscriberInterface
{
    /**
     * @var CommandFactoryResolverInterface
     */
    protected $commandFactoryResolver;

    /**
     * Our subscriber priority
     */
    const PRIORITY = 300;


    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return [KernelEvents::CONTROLLER => ['onKernelController', self::PRIORITY]];
    }

    /**
     * @param CommandFactoryResolverInterface $commandFactoryResolver
     */
    public function __construct(CommandFactoryResolverInterface $commandFactoryResolver)
    {
        $this->commandFactoryResolver = $commandFactoryResolver;
    }

    /**
     * @param FilterControllerEvent $event
     * @throws MissingAttributeException
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $request = $event->getRequest();

        // First, check if it's an Orchestra with a Command request
        if (! $request->attributes->has('command_class')) {
            return;
        }

        $commandClass = $request->attributes->get('command_class');

        // Do our command have a factory to use?
        $commandFactoryMethod = $this->commandFactoryResolver->getCommandFactory($commandClass);

        if (null !== $commandFactoryMethod) {
            if (! $request->attributes->has('object')) {
                throw new MissingAttributeException('object');
            }

            $object = $request->attributes->get('object');

            $command = call_user_func([$object, $commandFactoryMethod]);
        } else {
            // Otherwise we will call the constructor, but without any argument
            $reflection = new \ReflectionClass($commandClass);

            $command = $reflection->newInstance();
        }

        $request->attributes->set('command', $command);
    }
}