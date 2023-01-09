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
use LongitudeOne\PropertyBundle\Entity\StringProperty;
use PHPUnit\Framework\TestCase;

class StringPropertyTest extends TestCase
{
    private StringProperty $property;

    protected function setUp(): void
    {
        parent::setUp();
        $this->property = new StringProperty(new Definition());
    }

    public function testConstructor(): void
    {
        self::assertNull($this->property->getValue());
    }

    public function testValue(): void
    {
        // Integer
        self::assertSame($this->property, $this->property->setValue(42));
        self::assertSame('42', $this->property->getValue());

        // Float
        self::assertSame($this->property, $this->property->setValue(42.42));
        self::assertSame('42.42', $this->property->getValue());

        // string
        self::assertSame($this->property, $this->property->setValue('foo'));
        self::assertSame('foo', $this->property->getValue());

        // bool
        self::assertSame($this->property, $this->property->setValue(true));
        self::assertSame('1', $this->property->getValue());
        self::assertSame($this->property, $this->property->setValue(false));
        self::assertSame('', $this->property->getValue());

        // null
        self::assertSame($this->property, $this->property->setValue(null));
        self::assertNull($this->property->getValue());
    }
}
