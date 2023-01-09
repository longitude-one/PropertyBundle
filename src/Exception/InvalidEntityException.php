<?php

/**
 * This file is part of the LongitudeOne/PropertyBundle
 *
 * PHP 8.1 | Symfony 6.1+
 *
 * Copyright LongitudeOne - Alexandre Tranchant
 * Copyright 2021 - 2023
 */

namespace LongitudeOne\PropertyBundle\Exception;

class InvalidEntityException extends \InvalidArgumentException
{
    public function __construct(string $actual, string $expected, string $message = '', int $code = 404, ?\Throwable $previous = null)
    {
        if (empty($message)) {
            $message = sprintf(
                'Invalid entity exception: This property expects to be linked a "%s" entity,  "%s" provided',
                $expected,
                $actual,
            );
        }

        parent::__construct($message, $code, $previous);
    }
}
