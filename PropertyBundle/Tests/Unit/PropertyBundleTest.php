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

use LongitudeOne\PropertyBundle\LongitudeOnePropertyBundle;
use PHPUnit\Framework\TestCase;

class PropertyBundleTest extends TestCase
{
    public function testGetPath(): void
    {
        $bundle = new LongitudeOnePropertyBundle();
        self::assertSame(dirname(__DIR__, 3), $bundle->getPath());
    }
}
