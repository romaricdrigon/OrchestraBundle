<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle;

use RomaricDrigon\OrchestraBundle\DependencyInjection\Compiler\AddRepositoryCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class RomaricDrigonOrchestraBundle
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class RomaricDrigonOrchestraBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new AddRepositoryCompilerPass());
    }
}
