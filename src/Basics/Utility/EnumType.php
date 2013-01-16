<?php

namespace Basics\Utility;

/**
 * @author Ralf Fischer <themakii@gmail.com>
 */
abstract class EnumType
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
        } elseif (!in_array($this->value, $this->constants, true)) {
            throw new \LogicException('invalid parameter "$value"');
        }
    }


    /**
     * Select a new value
     *
     * @param mixed $value
     *
     * @throws \LogicException
     */
    private function setValue($value)
    {
        if (!in_array($value, $this->constants, true)) {
            throw new \LogicException('Unknown value <' . $value . '>');
        }
        $this->value = $value;
    }


    /**
     * Get the current enum value
     *
     * @return mixed
     */
    final public function getValue()
    {
        return $this->value;
    }


    /**
     * Get the current selected constant name
     *
     * @return string
     */
    final public function getName()
    {
        return array_search($this->value, $this->constants, true);
    }


    /**
     * Get the current selected constant name
     *
     * @return string
     * @see getName()
     */
    final public function __toString()
    {
        return $this->getName();
    }
}
