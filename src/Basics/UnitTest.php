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
    public function assertException(Closure $callable, $exceptionType, $messagePortion = null)
    {
        $exception = null;
        try {
            $callable();
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
