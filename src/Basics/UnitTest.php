<?php

namespace Basics;

/**
 * This class bundles some functionality for unit tests.
 *
 * @author Ralf Fischer <themakii@gmail.com>
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
     * @throws \Exception|\PHPUnit_Framework_Exception
     * @return void
     */
    public function assertException(\Closure $callable, $exceptionType, $messagePortion = null)
    {
        $exception = null;
        try {
            $callable();
            $this->fail('Expected exception "' . $exceptionType . '" not thrown');
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
