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

class PropertyNotFoundException extends \Exception implements \Throwable
{
    public function __construct(string $propertyName, string $message = '', int $code = 404, ?\Throwable $previous = null)
    {
        if (empty($message)) {
            $message = sprintf('Property named "%s" not found', $propertyName);
        }

        parent::__construct($message, $code, $previous);
    }
}
