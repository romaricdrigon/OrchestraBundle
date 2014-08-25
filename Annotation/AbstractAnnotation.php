<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Annotation;
use RomaricDrigon\OrchestraBundle\Exception\AnnotationWithoutValueException;

/**
 * Class AbstractAnnotation
 * Allow to create annotation in the form @ Annotation("value", option1="value1"...)
 *
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
abstract class AbstractAnnotation
{
    /**
     * @param array $options
     * @throws \InvalidArgumentException if our Annotation has options not allowed
     * @throws AnnotationWithoutValueException if our Annotation has a value and it shouldn't
     */
    public function __construct($options)
    {
        // Parse if our Annotation has a value
        if (isset($options['value'])) {
            $property = $this->getValueProperty();

            if (false === $property) {
                $reflect = new \ReflectionClass($this);
                $annotationName = $reflect->getShortName();

                throw new AnnotationWithoutValueException($annotationName);
            }

            $options[$property] = $options['value'];

            unset($options['value']);
        }

        foreach ($options as $key => $value) {
            if (! property_exists($this, $key)) {
                throw new \InvalidArgumentException(sprintf('Property "%s" does not exist', $key));
            }

            $this->$key = $value;
        }
    }

    /**
     * Returns the name of the class property where the annotation value should be copied into
     * Returns "false" if the annotation can not have a value (only options)
     *
     * @return string|false
     */
    abstract protected function getValueProperty();
} 