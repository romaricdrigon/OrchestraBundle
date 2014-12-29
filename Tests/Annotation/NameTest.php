<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Tests\Annotation;

use RomaricDrigon\OrchestraBundle\Annotation\Name;

/**
 * Class NameTest
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class NameTest extends \PHPUnit_Framework_TestCase
{
    public function test_it_accepts_value()
    {
        $name = new Name(['value' => 'some value']);

        $this->assertEquals('some value', $name->getName());
    }

    public function test_it_accepts_name_option()
    {
        $name = new Name(['name' => 'some value']);

        $this->assertEquals("some value", $name->getName());
    }

    public function test_it_does_not_allow_other_options()
    {
        $this->setExpectedException('RomaricDrigon\OrchestraBundle\Exception\AnnotationException');

        new Name(['value' => 'some value', 'foo' => 'bar']);
    }
}
 