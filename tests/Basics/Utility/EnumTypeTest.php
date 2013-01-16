<?php

namespace Basics\Utility;

/**
 * @author Ralf Fischer <themakii@gmail.com>
 */
class EnumTypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Basics\Utility\EnumType::__construct
     * @covers Basics\Utility\EnumType::setValue
     * @return TestEnumeration
     */
    public function testConstruction()
    {
        $enum = new TestEnumeration(TestEnumeration::FOO);
        $this->assertNotNull($enum);

        return $enum;
    }


    /**
     * @covers Basics\Utility\EnumType::__construct
     * @expectedException \LogicException
     */
    public function testConstructionFailsWhenNoDefaultValueWasDefined()
    {
        new TestEnumeration(); // default param = null, but no null value in TestEnumeration defined.
    }


    /**
     * @covers Basics\Utility\EnumType::__construct
     * @covers Basics\Utility\EnumType::setValue
     */
    public function testConstructionWithDefaultValueWorksWhenDefined()
    {
        $enum = new TestEnumerationWithNullDefault();

        $this->assertNotNull($enum);
    }


    /**
     * @covers Basics\Utility\EnumType::__construct
     * @covers Basics\Utility\EnumType::setValue
     * @expectedException \LogicException
     */
    public function testConstructionWithIllegalValueFails()
    {
        new TestEnumeration('snae');
    }

    /**
     * @param EnumType $enumType
     *
     * @depends testConstruction
     * @covers Basics\Utility\EnumType::getName
     */
    public function testGetNameWorksProperly(EnumType $enumType)
    {
        $this->assertSame('FOO', $enumType->getName());
    }

    /**
     * @param EnumType $enumType
     *
     * @depends testConstruction
     * @covers Basics\Utility\EnumType::getValue
     */
    public function testGetValueWorksProperly(EnumType $enumType)
    {
        $this->assertSame('foo', $enumType->getValue());
    }

    /**
     * @depends testConstruction
     * @covers Basics\Utility\EnumType::__toString
     */
    public function testToStringWorksAsExpected(EnumType $enumType)
    {
        $this->assertSame('FOO', '' . $enumType);
    }
}


class TestEnumeration extends EnumType
{
    const FOO = 'foo';
    const BAR = 'bar';
}

class TestEnumerationWithNullDefault extends EnumType
{
    const DEF = null;
    const FOO = 'foo';
    const BAR = 'bar';
}