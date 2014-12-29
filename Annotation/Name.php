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
 *
 * @Annotation
 */
class Name extends AbstractAnnotation
{
    /**
     * @var string Repository name
     */
    private $name;

    /**
     * @param string $name
     */
    protected function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    protected function getValueProperty()
    {
        return 'name';
    }
}
