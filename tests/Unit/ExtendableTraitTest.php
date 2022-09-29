<?php

/**
 * This file is part of the LongitudeOne/PropertyBundle
 *
 * PHP 8.1 | Symfony 6.1+
 *
 * Copyright LongitudeOne - Alexandre Tranchant
 * Copyright 2021 - 2022
 */

namespace LongitudeOne\PropertyBundle\Tests\Unit;

use LongitudeOne\PropertyBundle\Tests\Unit\Tools\ExtendableEntity;
use PHPUnit\Framework\TestCase;

class ExtendableTraitTest extends TestCase
{
    private ExtendableEntity $extendableEntity;

    protected function setUp(): void
    {
        parent::setUp();
        $this->extendableEntity = new ExtendableEntity();
    }

    public function testGetClassname(): void
    {
        self::assertSame('LongitudeOne\PropertyBundle\Tests\Unit\Tools\ExtendableEntity', $this->extendableEntity->getClassname());
    }
}
