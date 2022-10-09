<?php

/**
 * This file is part of the LongitudeOne/PropertyBundle
 *
 * PHP 8.1 | Symfony 6.1+
 *
 * Copyright LongitudeOne - Alexandre Tranchant
 * Copyright 2021 - 2022
 */

namespace LongitudeOne\PropertyBundle\Tests\Unit\Entity;

use LongitudeOne\PropertyBundle\Entity\Property;
use LongitudeOne\PropertyBundle\Tests\Tools\ToolEntity;
use PHPUnit\Framework\TestCase;

class PropertyTest extends TestCase
{
    private Property $property;

    protected function setUp(): void
    {
        parent::setUp();
        $this->property = new Property();
    }

    public function testClassname(): void
    {
        $entity = new ToolEntity();

        self::assertSame($this->property, $this->property->setEntity($entity));
        self::assertSame('LongitudeOne\PropertyBundle\Tests\Tools\ToolEntity', $this->property->getEntityClassname());
        self::assertSame(0, $this->property->getEntityId());
    }

    public function testName(): void
    {
        $actual = $expected = 'A name';

        self::assertSame($this->property, $this->property->setName($actual));
        self::assertSame($expected, $this->property->getName());
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
