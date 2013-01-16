<?php

namespace Basics\Utility;

/**
 * @author Ralf Fischer <themakii@gmail.com>
 */
class EnumTest extends \PHPUnit_Framework_TestCase
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
     * @param Enum $Enum
     *
     * @depends testConstruction
     * @covers Basics\Utility\Enum::getName
     */
    public function testGetNameWorksProperly(Enum $Enum)
    {
        $this->assertSame('FOO', $Enum->getName());
    }

    /**
     * @param Enum $Enum
     *
     * @depends testConstruction
     * @covers Basics\Utility\Enum::getValue
     */
    public function testGetValueWorksProperly(Enum $Enum)
    {
        $this->assertSame('foo', $Enum->getValue());
    }

    /**
     * @depends testConstruction
     * @covers Basics\Utility\Enum::__toString
     */
    public function testToStringWorksAsExpected(Enum $Enum)
    {
        $this->assertSame('FOO', '' . $Enum);
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