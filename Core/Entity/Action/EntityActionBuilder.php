<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Core\Entity\Action;

use RomaricDrigon\OrchestraBundle\Resolver\EmitEvent\EmitEventResolverInterface;
use RomaricDrigon\OrchestraBundle\Resolver\EntityRouteName\EntityRouteNameResolverInterface;
use RomaricDrigon\OrchestraBundle\Resolver\HiddenAction\HiddenActionResolverInterface;
use RomaricDrigon\OrchestraBundle\Core\Entity\EntityReflectionInterface;

/**
 * Class EntityActionBuilder
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class EntityActionBuilder implements EntityActionBuilderInterface
{
    /**
     * @var HiddenActionResolverInterface
     */
    protected $hiddenActionResolver;

    /**
     * @var EntityRouteNameResolverInterface
     */
    protected $entityRouteNameResolver;

    /**
     * @var EmitEventResolverInterface
     */
    protected $emitEventResolver;


    public function __construct(EntityRouteNameResolverInterface $entityRouteNameResolver, HiddenActionResolverInterface $hiddenActionResolver, EmitEventResolverInterface $emitEventResolver)
    {
        $this->hiddenActionResolver     = $hiddenActionResolver;
        $this->entityRouteNameResolver  = $entityRouteNameResolver;
        $this->emitEventResolver        = $emitEventResolver;
    }

    /**
     * @inheritdoc
     */
    public function build(EntityReflectionInterface $entityReflection, \ReflectionMethod $reflectionMethod)
    {
        if (true === $this->hiddenActionResolver->isHiddenReflectionMethod($reflectionMethod)) {
            return null;
        }

        $method = $reflectionMethod->getShortName();

        $name = $this->buildName($method);

        $routeName = $this->entityRouteNameResolver->getRouteName($entityReflection, $method);

        $slug = $this->buildMethodSlug($method);

        $command = $this->findCommand($reflectionMethod);

        $emitEvent = $this->emitEventResolver->methodEmitsEvent($reflectionMethod);

        $action = new EntityAction($method, $name, $routeName, $slug, $command, $emitEvent);

        return $action;
    }

    /**
     * Humanize name, adding a space before each capital
     *
     * @param string $name
     * @return string
     */
    protected function buildName($name)
    {
        $name = preg_replace('/([A-Z]{1})/', ' $1', $name);

        $name = ucfirst($name);

        return trim($name);
    }

    /**
     * Generate a slug - lowercase version of the name
     *
     * @param string $name
     * @return string
     */
    protected function buildMethodSlug($name)
    {
        return strtolower($name);
    }

    /**
     * Look if we have a parameter of type "CommandInterface", and then return its precise class name
     *
     * @param \ReflectionMethod $reflectionMethod
     * @return null|string
     */
    protected function findCommand(\ReflectionMethod $reflectionMethod)
    {
        $parameters = $reflectionMethod->getParameters();

        /** @var \ReflectionParameter $parameter */
        foreach ($parameters as $parameter) {
            $class = $parameter->getClass();

            if (null !== $class && true === $class->implementsInterface('RomaricDrigon\OrchestraBundle\Domain\Command\CommandInterface')) {
                return $class->getName();
            }
        }

        return null;
    }
}
