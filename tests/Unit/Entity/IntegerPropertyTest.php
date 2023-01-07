<?php

/**
 * This file is part of the LongitudeOne/PropertyBundle
 *
 * PHP 8.1 | Symfony 6.1+
 *
 * Copyright LongitudeOne - Alexandre Tranchant
 * Copyright 2021 - 2023
 */

namespace LongitudeOne\PropertyBundle\Tests\Unit\Entity;

use LongitudeOne\PropertyBundle\Entity\IntegerProperty;
use PHPUnit\Framework\TestCase;

class IntegerPropertyTest extends TestCase
{
    private IntegerProperty $property;

    protected function setUp(): void
    {
        parent::setUp();
        $this->property = new IntegerProperty();
    }

    public function testConstructor(): void
    {
        self::assertNull($this->property->getValue());
    }

    public function testValue(): void
    {
        // Integer
        $actual = $expected = 42;

        self::assertSame($this->property, $this->property->setValue($actual));
        self::assertSame($expected, $this->property->getValue());

        // Float
        $actual = 42.42;
        self::assertSame($this->property, $this->property->setValue($actual));
        self::assertSame($expected, $this->property->getValue());

        // string
        $actual = '42';
        self::assertSame($this->property, $this->property->setValue($actual));
        self::assertSame($expected, $this->property->getValue());

        // bool
        $actual = true;
        self::assertSame($this->property, $this->property->setValue($actual));
        self::assertSame(1, $this->property->getValue());

        // null
        self::assertSame($this->property, $this->property->setValue(null));
        self::assertNull($this->property->getValue());
    }
}
