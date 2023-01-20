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

use Doctrine\Common\Collections\ArrayCollection;
use LongitudeOne\PropertyBundle\Entity\Definition;
use LongitudeOne\PropertyBundle\Entity\NonTypedProperty;
use LongitudeOne\PropertyBundle\Tests\Tools\ToolEntity;
use PHPUnit\Framework\TestCase;

class ExtendableTraitTest extends TestCase
{
    private ToolEntity $entity;

    protected function setUp(): void
    {
        parent::setUp();
        $this->entity = new ToolEntity();
    }

    public function testGetProperties(): void
    {
        $properties = new ArrayCollection();
        $properties->add(new NonTypedProperty(new Definition()));
        $properties->add(new NonTypedProperty(new Definition()));

        self::assertSame($this->entity, $this->entity->setProperties($properties));
        self::assertSame($properties, $this->entity->getProperties());
    }
}
