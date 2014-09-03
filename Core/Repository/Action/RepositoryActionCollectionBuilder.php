<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Core\Repository\Action;

use RomaricDrigon\OrchestraBundle\Domain\Repository\RepositoryInterface;
use RomaricDrigon\OrchestraBundle\Resolver\HiddenAction\HiddenActionResolverInterface;
use RomaricDrigon\OrchestraBundle\Resolver\RepositoryNameResolverInterface;
use RomaricDrigon\OrchestraBundle\Resolver\RepositoryRouteName\RepositoryRouteNameResolverInterface;

/**
 * Class RepositoryActionCollectionBuilder
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class RepositoryActionCollectionBuilder implements RepositoryActionCollectionBuilderInterface
{
    /**
     * @var RepositoryNameResolverInterface
     */
    protected $repositoryNameResolver;

    /**
     * @var RepositoryRouteNameResolverInterface
     */
    protected $repositoryRouteNameResolver;

    /**
     * @var HiddenActionResolverInterface
     */
    protected $hiddenActionResolver;


    /**
     * @param RepositoryNameResolverInterface $repositoryNameResolver
     * @param RepositoryRouteNameResolverInterface $repositoryRouteNameResolver
     * @param HiddenActionResolverInterface $hiddenActionResolver
     */
    public function __construct(RepositoryNameResolverInterface $repositoryNameResolver, RepositoryRouteNameResolverInterface $repositoryRouteNameResolver, HiddenActionResolverInterface $hiddenActionResolver)
    {
        $this->repositoryNameResolver = $repositoryNameResolver;
        $this->repositoryRouteNameResolver = $repositoryRouteNameResolver;
        $this->hiddenActionResolver = $hiddenActionResolver;
    }

    /**
     * @inheritdoc
     */
    public function build(RepositoryInterface $repository)
    {
        $reflection = new \ReflectionClass($repository);

        $repoName = $this->repositoryNameResolver->getName($repository);

        $methods = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);

        $collection = new RepositoryActionCollection($repoName);

        foreach ($methods as $method) {
            if (true === $this->hiddenActionResolver->isHiddenReflectionMethod($method)) {
                continue;
            }

            $methodName = $method->getShortName();

            // For now, name is the humanized version of Method name
            $name = $this->humanizeName($methodName);

            $routeName = $this->repositoryRouteNameResolver->getRouteName($repository, $methodName);

            $action = new RepositoryAction($methodName, $name, $routeName);

            $collection->addAction($action);
        }

        return $collection;
    }

    /**
     * Humanize name, adding a space before each capital
     *
     * @param string $name
     * @return string
     */
    protected function humanizeName($name)
    {
        $name = preg_replace('/([A-Z]{1})/', ' $1', $name);

        $name = ucfirst($name);

        return trim($name);
    }
} 