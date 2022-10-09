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

class ExtandableTraitTest extends TestCase
{
    private ToolEntity $entity;

    protected function setUp(): void
    {
        parent::setUp();
        $this->entity = new ToolEntity();
    }

    public function testGetProperties(): void
    {
        $properties[] = new Property();
        $properties[] = new Property();

        self::assertSame($this->entity, $this->entity->setProperties($properties));
        self::assertSame($properties, $this->entity->getProperties());
    }
}
