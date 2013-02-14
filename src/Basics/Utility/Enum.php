<?php

namespace Basics\Utility;

/**
 * Synthetically creates a typed value which is based upon a constant, but
 * also allows the interpreter to do a simple type check when passing along
 * the value.
 *
 * To use it, just create a class with a bunch of constants.
 *
 * @author Ralf Fischer <themakii@gmail.com>
 */
abstract class Enum
{

    /**
     * The current selected value
     *
     * @var mixed
     */
    protected $value = null;

    /**
     * An array of available constants
     *
     * @var array
     */
    private $constants = null;


    /**
     * Constructor
     *
     * @param mixed $value The value to select
     *
     * @throws \LogicException
     */
    public function __construct($value = null)
    {
        $reflectionClass = new \ReflectionClass($this);
        $this->constants = $reflectionClass->getConstants();

        if (func_num_args() > 0 && $value !== null) {
            $this->setValue($value);
        } else if (!in_array($this->value, $this->constants, true)) {
            throw new \LogicException("invalid parameter '$value'");
        }
    }


    /**
     * Sets the value for this Enum instance.
     *
     * @param mixed $value The value of this Enum instance.
     *
     * @throws \LogicException When the value passed is not a valid value for this enumeration type.
     */
    private function setValue($value)
    {
        if (!in_array($value, $this->constants, true)) {
            throw new \LogicException('Unknown value <' . $value . '>');
        }
        $this->value = $value;
    }


    /**
     * Get the current enum value.
     *
     * @return mixed The value of this enumeration instance.
     */
    final public function getValue()
    {
        return $this->value;
    }


    /**
     * Get the current selected constant name of this enumeration.
     *
     * @return string
     */
    final public function getName()
    {
        return array_search($this->value, $this->constants, true);
    }


    /**
     * Get the current selected constant name.
     *
     * @return string
     * @see getName()
     */
    final public function __toString()
    {
        return $this->getName();
    }
}
