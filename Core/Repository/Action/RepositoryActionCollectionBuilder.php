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
     * @var RepositoryActionBuilderInterface
     */
    protected $repositoryActionBuilder;


    /**
     * @param RepositoryNameResolverInterface $repositoryNameResolver
     * @param RepositoryActionBuilderInterface $repositoryActionBuilder
     */
    public function __construct(RepositoryNameResolverInterface $repositoryNameResolver, RepositoryActionBuilderInterface $repositoryActionBuilder)
    {
        $this->repositoryNameResolver   = $repositoryNameResolver;
        $this->repositoryActionBuilder  = $repositoryActionBuilder;
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
            $action = $this->repositoryActionBuilder->build($repository, $method);

            if (null === $action) {
                continue;
            }

            $collection->addAction($action);
        }

        return $collection;
    }
}
