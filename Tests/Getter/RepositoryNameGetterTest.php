<?php

/*
 * This file is part of the Orchestra project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace RomaricDrigon\OrchestraBundle\Tests\Getter;

use RomaricDrigon\OrchestraBundle\Getter\RepositoryNameGetter;
use RomaricDrigon\OrchestraBundle\Tests\Pool\MockRepository1;

/**
 * Class RepositoryNameGetterTest
 * @author Romaric Drigon <romaric.drigon@gmail.com>
 */
class RepositoryNameGetterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RepositoryNameGetter
     */
    private $sut;
    
    public function setUp()
    {
        $this->sut = new RepositoryNameGetter();
    }

    public function test_it_generate_default_name()
    {
        $this->assertEquals('Mock1', $this->sut->getName(new MockRepository1()));
    }
}
 