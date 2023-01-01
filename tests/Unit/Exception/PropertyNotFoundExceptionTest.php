<?php

/**
 * This file is part of the LongitudeOne/PropertyBundle
 *
 * PHP 8.1 | Symfony 6.1+
 *
 * Copyright LongitudeOne - Alexandre Tranchant
 * Copyright 2021 - 2023
 */

namespace LongitudeOne\PropertyBundle\Tests\Unit\Exception;

use LongitudeOne\PropertyBundle\Exception\PropertyNotFoundException;
use PHPUnit\Framework\TestCase;

class PropertyNotFoundExceptionTest extends TestCase
{
    public function testConstruct(): void
    {
        $exception = new PropertyNotFoundException('myProperty');
        self::assertSame('Property named "myProperty" not found', $exception->getMessage());
        self::assertSame(404, $exception->getCode());
        self::assertGreaterThan(10, $exception->getLine());
    }
}
