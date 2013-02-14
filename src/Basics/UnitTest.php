<?php
namespace Basics;
/**
 * @author Ralf Fischer <themakii@gmail.com>
 */
class UnitTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param callable    $callable
     * @param string      $exceptionType
     * @param string|null $messagePortion
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
