<?php

namespace Basics\Collection;
use Basics\UnitTest;

/**
 * @author Ralf Fischer <themakii@gmail.com>
 */
class TypedListTest extends UnitTest
{
    /** @var TypedList|\PHPUnit_Framework_MockObject_MockObject */
    private $typedList;

    protected function setUp()
    {
        parent::setUp();
        $this->typedList = $this->getMockForAbstractClass('Basics\Collection\TypedList');
    }

    /**
     * @covers Basics\Collection\TypedList::add
     * @covers Basics\Collection\TypedList::count
     */
    public function testAddDelegatesToAssertionAndAddsItemWhenOfExpectedType()
    {
        $item = $this->expectItem();
        $this->typedList->expects($this->once())
            ->method('isExpectedType')
            ->with($item)
            ->will($this->returnValue(true)); // expected type

        $this->typedList->add($item);
        $this->assertCount(1, $this->typedList);
    }


    public function testAddDelegatesToAssertionAndThrowsExceptionWhenNotOfExpectedType()
    {
        $item = $this->expectItem();
        $this->typedList->expects($this->once())
            ->method('isExpectedType')
            ->with($item)
            ->will($this->returnValue(false)); // wrong type

        $typedList = $this->typedList;
        $this->assertException(function () use (&$typedList, $item) {
            $typedList->add($item);
        }, 'Basics\Collection\WrongItemTypeException');

        $this->assertCount(0, $this->typedList);
    }

    /**
     * @covers Basics\Collection\TypedList::add
     * @covers Basics\Collection\TypedList::count
     */
    public function testCountWorksProperly()
    {
        $this->expectSuccessiveCallsOnIsExpectedType(5, true);

        for ($i = 1; $i <= 5; $i++) {
            $this->assertCount($i - 1, $this->typedList);
            $item = $this->expectItem();
            $this->typedList->add($item);
            $this->assertCount($i, $this->typedList);
        }
    }

    /**
     * @covers Basics\Collection\TypedList::key
     * @covers Basics\Collection\TypedList::current
     * @covers Basics\Collection\TypedList::next
     * @covers Basics\Collection\TypedList::valid
     * @covers Basics\Collection\TypedList::rewind
     */
    public function testIteratorInterfaceWorksProperly()
    {
        $this->expectSuccessiveCallsOnIsExpectedType(3, true);

        $item0 = $this->expectItem();
        $item1 = $this->expectItem();
        $item2 = $this->expectItem();

        $this->typedList->add($item0);
        $this->typedList->add($item1);
        $this->typedList->add($item2);

        $this->assertIndexValidAndHoldsExpectedItem(0, $item0);
        $this->typedList->next();
        $this->assertIndexValidAndHoldsExpectedItem(1, $item1);
        $this->typedList->next();
        $this->assertIndexValidAndHoldsExpectedItem(2, $item2);

        // now, invalid position...
        $this->typedList->next();
        $this->assertAttributeSame(3, 'position', $this->typedList);
        $this->assertFalse($this->typedList->valid());
        $this->assertSame(3, $this->typedList->key());

        // start at the beginning
        $this->typedList->rewind();

        $this->assertAttributeSame(0, 'position', $this->typedList);
        $this->assertIndexValidAndHoldsExpectedItem(0, $item0);
    }

    /**
     * @covers Basics\Collection\TypedList::offsetGet
     */
    public function testArrayAccessOffsetGet()
    {
        $this->expectSuccessiveCallsOnIsExpectedType(4, true);

        $item0 = $this->expectItem();
        $item1 = $this->expectItem();
        $item2 = $this->expectItem();
        $item3 = $this->expectItem();

        $this->typedList->add($item0);
        $this->typedList->add($item1);
        $this->typedList->add($item2);
        $this->typedList->add($item3);

        $this->assertSame($item0, $this->typedList[0]);
        $this->assertSame($item1, $this->typedList[1]);
        $this->assertSame($item2, $this->typedList[2]);
        $this->assertSame($item3, $this->typedList[3]);
    }


    /**
     * @covers Basics\Collection\TypedList::offsetGet
     */
    public function testArrayAccessOffsetGetReturnsNullWhenIndexInvalid()
    {
        $this->expectSuccessiveCallsOnIsExpectedType(1, true);

        $item = $this->expectItem();
        $this->typedList->add($item);

        $this->assertSame($item, $this->typedList->offsetGet(0));
        $this->assertNull($this->typedList->offsetGet(1));
    }


    /**
     * @covers Basics\Collection\TypedList::offsetExists
     */
    public function testArrayAccessOffsetExists()
    {
        $this->expectSuccessiveCallsOnIsExpectedType(1, true);

        $item = $this->expectItem();
        $this->typedList->add($item);

        $this->assertTrue(isset($this->typedList[0]));
        $this->assertFalse(isset($this->typedList[1]));

        $this->assertTrue($this->typedList->offsetExists(0));
        $this->assertFalse($this->typedList->offsetExists(1));
    }

    /**
     * @covers Basics\Collection\TypedList::offsetSet
     * @covers Basics\Collection\TypedList::offsetGet
     */
    public function testOffsetSetAndGetWorkProperly()
    {
        $this->expectSuccessiveCallsOnIsExpectedType(3, true);

        $item0 = $this->expectItem();
        $item1 = $this->expectItem();
        $item2 = $this->expectItem();

        $this->typedList->add($item0);
        $this->typedList->add($item1);
        $this->typedList->add($item2);

        $this->assertSame($item0, $this->typedList[0]);
        $this->assertSame($item1, $this->typedList[1]);
        $this->assertSame($item2, $this->typedList[2]);

        $item1a = $this->expectItem();

        $this->typedList[1] = $item1a;

        $this->assertSame($item1a, $this->typedList->offsetGet(1));

        $item3 = $this->expectItem();
        $this->typedList->offsetSet(3, $item3);

        $this->assertCount(4, $this->typedList);
        $this->assertSame($item3, $this->typedList->offsetGet(3));
    }

    /**
     * @covers Basics\Collection\TypedList::offsetUnset
     */
    public function testOffsetUnsetWorksProperly()
    {
        $this->expectSuccessiveCallsOnIsExpectedType(3, true);

        $item0 = $this->expectItem();
        $item1 = $this->expectItem();
        $item2 = $this->expectItem();

        $this->typedList->add($item0);
        $this->typedList->add($item1);
        $this->typedList->add($item2);

        $this->assertCount(3, $this->typedList);

        unset($this->typedList[1]);

        $this->assertCount(2, $this->typedList);

        $this->typedList->offsetUnset(0);

        $this->assertCount(1, $this->typedList);

        $this->assertSame($item2, $this->typedList->offsetGet(2));
    }

    /**
     * @covers Basics\Collection\TypedList::init
     */
    public function testInitWorksProperly()
    {
        $this->assertAttributeSame(array(), 'items', $this->typedList);
        $this->assertAttributeSame(0, 'position', $this->typedList);

        $items = array(
            $this->expectItem(),
            $this->expectItem()
        );

        $this->invokeUnreachableMethod($this->typedList, 'init', array($items, 1));

        $this->assertAttributeSame($items, 'items', $this->typedList);
        $this->assertAttributeSame(1, 'position', $this->typedList);
    }


    /**
     * @covers Basics\Collection\TypedList::filter
     */
    public function testFilterWorksProperly()
    {
        $at0NotMatching = $this->expectItem();
        $at1Matching    = $this->expectItem();
        $at2NotMatching = $this->expectItem();
        $at3NotMatching = $this->expectItem();
        $at4Matching    = $this->expectItem();
        $at5NotMatching = $this->expectItem();

        $this->expectSuccessiveCallsOnIsExpectedType(6, true);

        $this->typedList->add($at0NotMatching);
        $this->typedList->add($at1Matching);
        $this->typedList->add($at2NotMatching);
        $this->typedList->add($at3NotMatching);
        $this->typedList->add($at4Matching);
        $this->typedList->add($at5NotMatching);

        $matcher = function (Item $item) use ($at1Matching, $at4Matching) {
            if ($at1Matching === $item || $at4Matching === $item) {
                return true;
            }
            return false;
        };

        $result = $this->invokeUnreachableMethod($this->typedList, 'filter', array($matcher));

        $this->assertCount(2, $result);
        $this->assertSame(array($at1Matching, $at4Matching), $result);
    }

    /**
     * Asserts a certain item at a certain index of the typed list.
     *
     * @param int  $index The index of the expected item.
     * @param Item $item  The item expected at index.
     */
    private function assertIndexValidAndHoldsExpectedItem($index, Item $item)
    {
        $this->assertAttributeSame($index, 'position', $this->typedList);
        $this->assertSame($index, $this->typedList->key());
        $this->assertTrue($this->typedList->valid());
        $this->assertSame($item, $this->typedList->current());
    }

    /**
     * @param int  $count
     * @param bool $isExpectedType
     */
    private function expectSuccessiveCallsOnIsExpectedType($count, $isExpectedType)
    {
        $this->typedList->expects($this->exactly($count))
            ->method('isExpectedType')
            ->with($this->isInstanceOf('Basics\Collection\Item'))
            ->will($this->returnValue($isExpectedType));
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Item
     */
    private function expectItem()
    {
        return $this->getMock('Basics\Collection\Item');
    }
}
