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
use LongitudeOne\PropertyBundle\Tests\Tools\ToolEntity;
use PHPUnit\Framework\TestCase;

class DefinitionTest extends TestCase
{
    private Definition $definition;

    protected function setUp(): void
    {
        parent::setUp();
        $this->definition = new Definition();
    }

    public function testClassname(): void
    {
        $entity = new ToolEntity();

        self::assertSame($this->definition, $this->definition->setEntityClassname($entity->getLinkedClassname()));
        self::assertSame('LongitudeOne\PropertyBundle\Tests\Tools\ToolEntity', $this->definition->getEntityClassname());
    }

    public function testConstructor(): void
    {
        self::assertFalse($this->definition->isEnabled());
    }

    public function testEntity(): void
    {
        $entity = new ToolEntity();

        self::assertSame($this->definition, $this->definition->setEntity($entity));
        self::assertSame('LongitudeOne\PropertyBundle\Tests\Tools\ToolEntity', $this->definition->getEntityClassname());
    }

    public function testEntityWithFoo(): void
    {
        $entity = new \stdClass();

        self::assertSame($this->definition, $this->definition->setEntity($entity));
        self::assertSame('stdClass', $this->definition->getEntityClassname());
    }

    public function testName(): void
    {
        $actual = $expected = 'A name';

        self::assertSame($this->definition, $this->definition->setName($actual));
        self::assertSame($expected, $this->definition->getName());
    }
}
