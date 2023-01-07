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

use LongitudeOne\PropertyBundle\Entity\FloatProperty;
use PHPUnit\Framework\TestCase;

class FloatPropertyTest extends TestCase
{
    private FloatProperty $property;

    protected function setUp(): void
    {
        parent::setUp();
        $this->property = new FloatProperty();
    }

    public function testConstructor(): void
    {
        self::assertNull($this->property->getValue());
    }

    public function testValue(): void
    {
        $expected = 42.0;

        // Integer
        self::assertSame($this->property, $this->property->setValue(42));
        self::assertSame($expected, $this->property->getValue());

        // Float
        self::assertSame($this->property, $this->property->setValue(42.0));
        self::assertSame($expected, $this->property->getValue());

        // string
        $actual = '42';
        self::assertSame($this->property, $this->property->setValue($actual));
        self::assertSame($expected, $this->property->getValue());

        // bool
        self::assertSame($this->property, $this->property->setValue(true));
        self::assertSame(1.0, $this->property->getValue());
        self::assertSame($this->property, $this->property->setValue(false));
        self::assertSame(0.0, $this->property->getValue());

        // null
        self::assertSame($this->property, $this->property->setValue(null));
        self::assertNull($this->property->getValue());
    }
}
