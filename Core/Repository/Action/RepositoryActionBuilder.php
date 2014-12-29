<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Core\Repository\Action;

use RomaricDrigon\OrchestraBundle\Domain\Repository\RepositoryInterface;
use RomaricDrigon\OrchestraBundle\Resolver\RepositoryRouteName\RepositoryRouteNameResolverInterface;
use RomaricDrigon\OrchestraBundle\Resolver\HiddenAction\HiddenActionResolverInterface;

/**
 * Class RepositoryActionBuilder
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class RepositoryActionBuilder implements RepositoryActionBuilderInterface
{
    /**
     * @var RepositoryRouteNameResolverInterface
     */
    protected $repositoryRouteNameResolver;

    /**
     * @var HiddenActionResolverInterface
     */
    protected $hiddenActionResolver;


    /**
     * @param RepositoryRouteNameResolverInterface $repositoryRouteNameResolver
     * @param HiddenActionResolverInterface $hiddenActionResolver
     */
    public function __construct(RepositoryRouteNameResolverInterface $repositoryRouteNameResolver, HiddenActionResolverInterface $hiddenActionResolver)
    {
        $this->repositoryRouteNameResolver = $repositoryRouteNameResolver;
        $this->hiddenActionResolver = $hiddenActionResolver;
    }

    /**
     * @inheritdoc
     */
    public function build(RepositoryInterface $repository, \ReflectionMethod $reflectionMethod)
    {
        if (true === $this->hiddenActionResolver->isHiddenReflectionMethod($reflectionMethod)) {
            return null;
        }

        $method = $reflectionMethod->getShortName();

        $name = $this->buildName($method);

        $routeName = $this->repositoryRouteNameResolver->getRouteName($repository, $method);

        $slug = $this->buildSlug($method);

        $command = $this->findCommand($reflectionMethod);

        $action = new RepositoryAction($method, $name, $routeName, $slug, $command);

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
    protected function buildSlug($name)
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
