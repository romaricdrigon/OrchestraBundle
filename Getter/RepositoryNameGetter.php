<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Getter;

use RomaricDrigon\OrchestraBundle\Domain\RepositoryInterface;

/**
 * Class RepositoryNameGetter
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class RepositoryNameGetter implements RepositoryNameGetterInterface
{
    /**
     * @inheritdoc
     */
    public function getName(RepositoryInterface $repository)
    {
        return $this->generateDefaultName($repository);
    }

    /**
     * Returns a string extracted from Repository class name, without the "Repository" part
     *
     * @param RepositoryInterface $repository
     * @return string
     */
    protected function generateDefaultName(RepositoryInterface $repository)
    {
        $reflect = new \ReflectionClass($repository);

        return str_replace('Repository', '', $reflect->getShortName());
    }
}