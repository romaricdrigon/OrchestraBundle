<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Annotation;

/**
 * Class Name
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class Name extends AbstractAnnotation
{
    /**
     * @var string Repository name
     */
    private $name;

    protected function getValueProperty()
    {
        return 'name';
    }
} 