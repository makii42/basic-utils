<?php

namespace Basics\Utility;

use Basics\UnitTest;

/**
 * @author Ralf Fischer <themakii@gmail.com>
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