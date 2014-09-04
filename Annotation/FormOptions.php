<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Annotation;

/**
 * Class FormOptions
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 *
 * @Annotation
 */
class FormOptions extends AbstractAnnotation
{
    /**
     * @var string
     */
    protected $options;

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options ?: [];
    }

    /**
     * @param array $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }

    /**
     * @inheritdoc
     */
    protected function getValueProperty()
    {
        return 'options';
    }
} 