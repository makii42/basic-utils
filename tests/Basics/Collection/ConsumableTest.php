<?php
/*
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

namespace Basics\Collection;

/**
 *
 * @package    Basics\Collection
 * @author     Ralf Fischer <themakii@gmail.com>
 * @copyright  2012-2013 Ralf Fischer <themakii@gmail.com>
 * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       http://github.com/makii42/${PROJECT_NAME}
 */
class ConsumableTest extends \PHPUnit_Framework_TestCase
{

    public function testHasMoreReturnsFalseWhenEmptyArrayIsPassed()
    {
        $consumable = new Consumable(array());

        $this->assertFalse($consumable->hasMore());
        $this->assertFalse($consumable->hasMore());
    }

    public function testHasMoreReturnsTrueButFalseWhenEndIsReached()
    {
        $consumable = new Consumable(array('not empty'));

        $this->assertTrue($consumable->hasMore());
        $consumable->consumeNext();
        $this->assertFalse($consumable->hasMore());
    }

    public function testConsumeNextReturnsFromTheBeginning()
    {
        $first  = 'first';
        $second = 'second';

        $consumable = new Consumable(array($first, $second));

        $this->assertTrue($consumable->hasMore());
        $this->assertSame($first, $consumable->consumeNext());
        $this->assertSame($second, $consumable->consumeNext());
    }

    public function testConsumeNextReturnsNullWhenEmpty()
    {
        $consumable = new Consumable(array());
        $this->assertNull($consumable->consumeNext());
    }

    public function testConsumeReturnsElementButNullWhenEndIsReached()
    {
        $foo = 'foo';
        $bar = 'bar';

        $consumable = new Consumable(array($foo, $bar));

        $this->assertSame($foo, $consumable->consumeNext());
        $this->assertSame($bar, $consumable->consumeNext());
        $this->assertNull($consumable->consumeNext());
    }
}
