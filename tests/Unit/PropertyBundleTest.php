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

use LongitudeOne\PropertyBundle\PropertyBundle;
use PHPUnit\Framework\TestCase;

class PropertyBundleTest extends TestCase
{
    public function testGetPath(): void
    {
        $bundle = new PropertyBundle();
        self::assertSame(dirname(__DIR__).'/tests', $bundle->getPath());
    }
}
