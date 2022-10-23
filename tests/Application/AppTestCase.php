<?php

/**
 * This file is part of the LongitudeOne/PropertyBundle
 *
 * PHP 8.1 | Symfony 6.1+
 *
 * Copyright LongitudeOne - Alexandre Tranchant
 * Copyright 2021 - 2022
 */

namespace LongitudeOne\PropertyBundle\Tests\Application;

use LongitudeOne\PropertyBundle\Tests\App\Kernel;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as SymfonyWebTestCase;

abstract class AppTestCase extends SymfonyWebTestCase
{
    protected static function getKernelClass(): string
    {
        return Kernel::class;
    }
}
