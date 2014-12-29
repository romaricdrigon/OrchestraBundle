<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Annotation;

/**
 * Class Security
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 *
 * @Annotation
 */
class Security extends AbstractAnnotation
{
    /**
     * @var string
     */
    protected $expression;

    /**
     * @return string
     */
    public function getExpression()
    {
        return $this->expression;
    }

    /**
     * @param string $expression
     */
    public function setExpression($expression)
    {
        $this->expression = $expression;
    }

    /**
     * @inheritdoc
     */
    protected function getValueProperty()
    {
        return 'expression';
    }
}
