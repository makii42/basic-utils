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

namespace Basics\Utility;

/**
 * Synthetically creates a typed value which is based upon a constant, but
 * also allows the interpreter to do a simple type check when passing along
 * the value.
 *
 * To use it, just create a class with a bunch of constants.
 *
 * @package    Basics\Utility
 * @author     Ralf Fischer <themakii@gmail.com>
 * @copyright  2012-2013 Ralf Fischer <themakii@gmail.com>
 * @license    http://www.opensource.org/licenses/BSD-3-Clause  The BSD 3-Clause License
 * @link       http://github.com/makii42/basic-utils
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
