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

use LongitudeOne\PropertyBundle\Entity\Definition;
use LongitudeOne\PropertyBundle\Entity\NonTypedProperty;
use PHPUnit\Framework\TestCase;

class PropertyTest extends TestCase
{
    private NonTypedProperty $property;

    protected function setUp(): void
    {
        parent::setUp();
        $this->property = new NonTypedProperty(new Definition());
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
        $actual = $expected = 42.42;

        self::assertSame($this->property, $this->property->setValue($actual));
        self::assertSame($expected, $this->property->getValue());

        // string
        $actual = $expected = 'A string value';

        self::assertSame($this->property, $this->property->setValue($actual));
        self::assertSame($expected, $this->property->getValue());

        // bool
        self::assertSame($this->property, $this->property->setValue(false));
        self::assertFalse($this->property->getValue());

        // null
        self::assertSame($this->property, $this->property->setValue(null));
        self::assertNull($this->property->getValue());
    }
}
