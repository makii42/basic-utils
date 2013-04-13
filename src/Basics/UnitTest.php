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

namespace Basics;

/**
 * This class bundles some functionality for unit tests.
 *
 * @package    Basics
 * @author     Ralf Fischer <themakii@gmail.com>
 * @copyright  2012-2013 Ralf Fischer <themakii@gmail.com>
 * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       http://github.com/makii42/basic-utils
 */
abstract class UnitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Asserts a certain exception is thrown in a closure. If it's not thrown,
     * the assertion will fail. You need to specify the type of the exception,
     * as a string, which also is asserted.
     *
     * Additionally you may specify a string, which is expected to be contained
     * in the message string of the exception. This one is optional.
     *
     * @param callable    $callable       The callable throwing the exception.
     * @param string      $exceptionType  The type of the expected exception
     * @param string|null $messagePortion A string expected to be in the message of the thrown exception.
     * @throws \Exception|\PHPUnit_Framework_Exception|\PHPUnit_Framework_Error
     * @return void
     */
    public function assertException(\Closure $callable, $exceptionType, $messagePortion = null)
    {
        $exception = null;
        try {
            $callable();
            $this->fail('Expected exception "' . $exceptionType . '" not thrown');
        } catch (\PHPUnit_Framework_Error $e) {
            throw $e;
        } catch (\PHPUnit_Framework_Exception $e) {
            // rethrow this, might be the fail above, or a mock expectation.
            throw $e;
        } catch (\Exception $e) {
            $exception = $e;
        }
        $this->assertNotNull($exception);
        $this->assertInstanceOf($exceptionType, $exception);
        if ($messagePortion !== null) {
            $this->assertContains($messagePortion, $exception->getMessage());
        }
    }

    /**
     * Invokes a method which usually is not accessible because of the access modifier.
     *
     * Usually you should try to avoid using this, as it might indicate a design flaw. On the other
     * hand, e.g. when using delegate methods.
     *
     * @param mixed  $object The object to invoke the method on.
     * @param string $method The method to invoke.
     * @param array  $args   The parameters to the invocation.
     * @return mixed The result of the method invocation.
     */
    public function invokeUnreachableMethod($object, $method, array $args = array())
    {
        $this->assertInternalType('object', $object, '"object" is no object.');

        $class  = new \ReflectionClass($object);
        $method = $class->getMethod($method);
        $method->setAccessible(true);

        $this->assertNotNull($method, 'did not find method "' . $method . '".');

        return $method->invokeArgs($object, $args);
    }
}
