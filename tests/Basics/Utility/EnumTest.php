<?php
/**
 * basic-utils
 *
 * Copyright (c) 2012-2013, Ralf Fischer <themakii@gmail.com>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *  * Redistributions of source code must retain the above copyright
 *    notice, this list of conditions and the following disclaimer.
 *
 * * Redistributions in binary form must reproduce the above copyright
 *    notice, this list of conditions and the following disclaimer in
 *    the documentation and/or other materials provided with the
 *    distribution.
 *
 * * Neither the name of Ralf Fischer nor the names of his
 *    contributors may be used to endorse or promote products derived
 *    from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 */

namespace Basics\Utility;

use Basics\UnitTest;

/**
 * @package    Basics\Utility
 * @author     Ralf Fischer <themakii@gmail.com>
 * @copyright  2012-2013 Ralf Fischer <themakii@gmail.com>
 * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       http://github.com/makii42/basic-utils
 */
class EnumTest extends UnitTest
{
    /**
     * @covers Basics\Utility\Enum::__construct
     * @covers Basics\Utility\Enum::setValue
     * @return TestEnumeration
     */
    public function testConstruction()
    {
        $enum = new TestEnumeration(TestEnumeration::FOO);
        $this->assertNotNull($enum);

        return $enum;
    }


    /**
     * @covers Basics\Utility\Enum::__construct
     * @expectedException \LogicException
     */
    public function testConstructionFailsWhenNoDefaultValueWasDefined()
    {
        new TestEnumeration(); // default param = null, but no null value in TestEnumeration defined.
    }


    /**
     * @covers Basics\Utility\Enum::__construct
     * @covers Basics\Utility\Enum::setValue
     */
    public function testConstructionWithDefaultValueWorksWhenDefined()
    {
        $enum = new TestEnumerationWithNullDefault();

        $this->assertNotNull($enum);
    }


    /**
     * @covers Basics\Utility\Enum::__construct
     * @covers Basics\Utility\Enum::setValue
     * @expectedException \LogicException
     */
    public function testConstructionWithIllegalValueFails()
    {
        new TestEnumeration('snae');
    }

    /**
     * @param Enum $enum
     *
     * @depends testConstruction
     * @covers Basics\Utility\Enum::getName
     */
    public function testGetNameWorksProperly(Enum $enum)
    {
        $this->assertSame('FOO', $enum->getName());
    }

    /**
     * @param Enum $enum
     *
     * @depends testConstruction
     * @covers Basics\Utility\Enum::getValue
     */
    public function testGetValueWorksProperly(Enum $enum)
    {
        $this->assertSame('foo', $enum->getValue());
    }

    /**
     * @depends testConstruction
     * @covers Basics\Utility\Enum::__toString
     */
    public function testToStringWorksAsExpected(Enum $enum)
    {
        $this->assertSame('FOO', '' . $enum);
    }
}


class TestEnumeration extends Enum
{
    const FOO = 'foo';
    const BAR = 'bar';
}

class TestEnumerationWithNullDefault extends Enum
{
    const DEF = null;
    const FOO = 'foo';
    const BAR = 'bar';
}