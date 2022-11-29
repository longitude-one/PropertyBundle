<?php

/**
 * This file is part of the LongitudeOne/PropertyBundle
 *
 * PHP 8.1 | Symfony 6.1+
 *
 * Copyright LongitudeOne - Alexandre Tranchant
 * Copyright 2021 - 2022
 */

namespace LongitudeOne\PropertyBundle\Validator;

use Symfony\Component\Validator\Constraint;

class InstanceOfExtendable extends Constraint
{
    public string $message = 'The "{{ class }}" entity cannot be customize. Did you forget to implement  the ExtendableInterface?';
    // If the constraint has configuration options, define them as public properties
    // public string $mode = 'strict';
}
