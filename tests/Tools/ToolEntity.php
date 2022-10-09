<?php

/**
 * This file is part of the LongitudeOne/PropertyBundle
 *
 * PHP 8.1 | Symfony 6.1+
 *
 * Copyright LongitudeOne - Alexandre Tranchant
 * Copyright 2021 - 2022
 */

namespace LongitudeOne\PropertyBundle\Tests\Tools;

use LongitudeOne\PropertyBundle\Entity\ExtendableInterface;
use LongitudeOne\PropertyBundle\Entity\ExtendableTrait;
use LongitudeOne\PropertyBundle\Entity\LinkedInterface;
use LongitudeOne\PropertyBundle\Entity\LinkedTrait;

class ToolEntity implements ExtendableInterface, LinkedInterface
{
    use ExtendableTrait;
    use LinkedTrait;

    public function getLinkedId(): int
    {
        return 0;
    }
}
