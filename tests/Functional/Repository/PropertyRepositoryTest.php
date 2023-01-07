<?php

/**
 * This file is part of the LongitudeOne/PropertyBundle
 *
 * PHP 8.1 | Symfony 6.1+
 *
 * Copyright LongitudeOne - Alexandre Tranchant
 * Copyright 2021 - 2023
 */

namespace LongitudeOne\PropertyBundle\Tests\Functional\Repository;

use LongitudeOne\PropertyBundle\Entity\NonTypedProperty;
use LongitudeOne\PropertyBundle\Repository\NonTypedPropertyRepository;
use LongitudeOne\PropertyBundle\Tests\Functional\DatabaseTestCase;
use LongitudeOne\PropertyBundle\Tests\Tools\ToolEntity;

class PropertyRepositoryTest extends DatabaseTestCase
{
    private NonTypedPropertyRepository $propertyRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->propertyRepository = $this->getEntityManager()->getRepository(NonTypedProperty::class);
    }

    public function testFindNonExistent(): void
    {
        $linkedEntity = new ToolEntity();
        self::assertNull($this->propertyRepository->findProperty($linkedEntity, 'foo'));
        self::assertCount(0, $this->propertyRepository->findAllProperties($linkedEntity));
    }
}
