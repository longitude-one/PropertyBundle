<?php

/**
 * This file is part of the LongitudeOne/PropertyBundle
 *
 * PHP 8.1 | Symfony 6.1+
 *
 * Copyright LongitudeOne - Alexandre Tranchant
 * Copyright 2021 - 2023
 */

// TODO move to the good directory!
namespace LongitudeOne\PropertyBundle\Entity\LongitudeOne\PropertyBundle\Exception;

class InvalidTypeException extends \InvalidArgumentException implements \Throwable
{
    public function __construct(int $type, string $message = null, int $code = 0, ?\Throwable $previous = null)
    {
        if (empty($message)) {
            $message = sprintf('Invalid type %s. Definitions only accepts mixed(0), integer(1), float(2) or string(3) values.', $type);
        }

        parent::__construct($message, $code, $previous);
    }
}
