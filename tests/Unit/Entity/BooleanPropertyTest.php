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

use LongitudeOne\PropertyBundle\Entity\BooleanProperty;
use LongitudeOne\PropertyBundle\Entity\Definition;
use PHPUnit\Framework\TestCase;

class BooleanPropertyTest extends TestCase
{
    private BooleanProperty $property;

    protected function setUp(): void
    {
        parent::setUp();
        $this->property = new BooleanProperty(new Definition());
    }

    public function testConstructor(): void
    {
        self::assertNull($this->property->getValue());
    }

    public function testValue(): void
    {
        // Integer
        self::assertSame($this->property, $this->property->setValue(42));
        self::assertTrue($this->property->getValue());
        self::assertSame($this->property, $this->property->setValue(0));
        self::assertFalse($this->property->getValue());

        // Float
        self::assertSame($this->property, $this->property->setValue(42.42));
        self::assertTrue($this->property->getValue());
        self::assertSame($this->property, $this->property->setValue(0.0));
        self::assertFalse($this->property->getValue());

        // string
        self::assertSame($this->property, $this->property->setValue('42'));
        self::assertTrue($this->property->getValue());
        self::assertSame($this->property, $this->property->setValue('0'));
        self::assertFalse($this->property->getValue());

        // bool
        self::assertSame($this->property, $this->property->setValue(true));
        self::assertTrue($this->property->getValue());
        self::assertSame($this->property, $this->property->setValue(false));
        self::assertFalse($this->property->getValue());

        // null
        self::assertSame($this->property, $this->property->setValue(null));
        self::assertNull($this->property->getValue());
    }
}
