<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Annotation;

/**
 * Class FormType
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 *
 * @Annotation
 */
class FormType extends AbstractAnnotation
{
    /**
     * @var string
     */
    protected $type;

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @inheritdoc
     */
    protected function getValueProperty()
    {
        return 'type';
    }
}
