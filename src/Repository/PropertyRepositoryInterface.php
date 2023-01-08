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

use LongitudeOne\PropertyBundle\Entity\LinkedInterface;
use LongitudeOne\PropertyBundle\Entity\PropertyInterface;

interface PropertyRepositoryInterface
{
    /**
     * @return array<int,PropertyInterface>
     */
    public function findByEntity(LinkedInterface $linkedEntity): iterable;

    public function findByEntityAndName(LinkedInterface $linkedEntity, string $propertyName): ?PropertyInterface;

    public function remove(PropertyInterface $property, bool $flush = false): void;

    public function save(PropertyInterface $property, bool $flush = false): void;
}
