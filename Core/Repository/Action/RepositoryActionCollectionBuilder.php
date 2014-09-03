<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Core\Repository\Action;

use RomaricDrigon\OrchestraBundle\Domain\Repository\RepositoryInterface;
use RomaricDrigon\OrchestraBundle\Resolver\RepositoryNameResolverInterface;

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
     * @param RepositoryNameResolverInterface $repositoryNameResolver
     */
    public function __construct(RepositoryNameResolverInterface $repositoryNameResolver)
    {
        $this->repositoryNameResolver = $repositoryNameResolver;
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
            $methodName = $method->getShortName();

            // For now, name is the humanized version of Method name
            $name = $this->humanizeName($methodName);

            $action = new RepositoryAction($methodName, $name);

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