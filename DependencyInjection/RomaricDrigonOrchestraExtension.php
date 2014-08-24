<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

/**
 * Class RomaricDrigonOrchestraExtension
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class RomaricDrigonOrchestraExtension extends ConfigurableExtension
{
    /**
     * {@inheritDoc}
     */
    public function loadInternal(array $mergedConfig, ContainerBuilder $container)
    {
        // Register services
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        // We must also add our bundle to Assetic configuration
        $asseticBundle = $container->getParameter('assetic.bundles');
        $asseticBundle[] = 'RomaricDrigonOrchestraBundle';
        $container->setParameter('assetic.bundles', $asseticBundle);

        // We pass app_title to Twig
        $twigGlobals = $container->getParameter('twig.globals');
        $twigGlobals['orchestra_app_title'] = $mergedConfig['app_title'];
        $container->setParameter('twig.globals', $twigGlobals);
    }
}
