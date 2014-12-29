<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Annotation;

/**
 * Class CommandFactory
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 *
 * @Annotation
 */
class CommandFactory extends AbstractAnnotation
{
    /**
     * @var string name oif the method on the entity to use
     */
    private $method;

    /**
     * @param string $method
     */
    protected function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @inheritdoc
     */
    protected function getValueProperty()
    {
        return 'method';
    }
}
