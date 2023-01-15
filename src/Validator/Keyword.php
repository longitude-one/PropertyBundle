<?php

/**
 * This file is part of the LongitudeOne/PropertyBundle
 *
 * PHP 8.1 | Symfony 6.1+
 *
 * Copyright LongitudeOne - Alexandre Tranchant
 * Copyright 2021 - 2023
 */

namespace LongitudeOne\PropertyBundle\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class Keyword extends Constraint
{
    public string $message = 'The keyword "{{ keyword }}" shall only be composed by letters optionally separated with - or _';
}
