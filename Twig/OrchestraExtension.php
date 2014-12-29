<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Twig;

/**
 * Class OrchestraExtension
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class OrchestraExtension extends \Twig_Extension
{
    /**
     * @var string
     */
    protected $appTitle;

    public function __construct($appTitle)
    {
        $this->appTitle = $appTitle;
    }

    /**
     * @inheritdoc
     */
    public function getGlobals()
    {
        return [
            'orchestra_app_title' => $this->appTitle
        ];
    }

    public function getName()
    {
        return 'orchestra_extension';
    }
}
