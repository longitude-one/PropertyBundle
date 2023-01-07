<?php

/**
 * This file is part of the LongitudeOne/PropertyBundle
 *
 * PHP 8.1 | Symfony 6.1+
 *
 * Copyright LongitudeOne - Alexandre Tranchant
 * Copyright 2021 - 2023
 */

namespace LongitudeOne\PropertyBundle\Repository;

use Doctrine\Persistence\ManagerRegistry;
use LongitudeOne\PropertyBundle\Entity\StringProperty;

class StringPropertyRepository extends AbstractPropertyRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StringProperty::class);
    }
}
