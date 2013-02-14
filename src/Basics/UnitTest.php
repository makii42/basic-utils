<?php

namespace Basics;

/**
 * This class bundles some functionality for unit tests.
 *
 * @author Ralf Fischer <themakii@gmail.com>
 */
class UnitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Asserts a certain exception is thrown in a closure. If it's not thrown,
     * the assertion will fail. You need to specify the type of the exception,
     * as a string, which also is asserted.
     *
     * Additionally you may specify a string, which is expected to be contained
     * in the message string of the exception. This one is optional.
     *
     * @param callable    $callable
     * @param string      $exceptionType
     * @param string|null $messagePortion
     * @throws \PHPUnit_Framework_Exception
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
}
