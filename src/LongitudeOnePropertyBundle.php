<?php

/**
 * This file is part of the LongitudeOne/PropertyBundle
 *
 * PHP 8.1 | Symfony 6.1+
 *
 * Copyright LongitudeOne - Alexandre Tranchant
 * Copyright 2021 - 2022
 */

namespace LongitudeOne\PropertyBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class LongitudeOnePropertyBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
