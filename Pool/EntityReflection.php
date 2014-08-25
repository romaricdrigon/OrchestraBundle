<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Pool;

/**
 * Class EntityReflection
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class EntityReflection implements EntityReflectionInterface
{
    /**
     * @var \ReflectionClass
     */
    protected $reflectionClass;


    public function __construct(\ReflectionClass $reflectionClass)
    {
        $this->reflectionClass = $reflectionClass;
    }

    /**
     * @inheritdoc
     */
    public function getReflectionClass()
    {
        return $this->reflectionClass;
    }
} 