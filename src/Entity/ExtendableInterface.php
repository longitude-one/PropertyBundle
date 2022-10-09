<?php

/**
 * This file is part of the LongitudeOne/PropertyBundle
 *
 * PHP 8.1 | Symfony 6.1+
 *
 * Copyright LongitudeOne - Alexandre Tranchant
 * Copyright 2021 - 2022
 */

namespace LongitudeOne\PropertyBundle\Entity;

interface ExtendableInterface
{
    /**
     * @return PropertyInterface[]
     */
    public function getProperties(): iterable;

    /**
     * @param PropertyInterface[] $properties
     */
    public function setProperties(iterable $properties): self;
}
